<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Resources\JobCollection;
use Log;

class JobController extends Controller
{
    private $size = 4;
    private $search_api_url;
    private $members_api_url;
    private $jobs_api_url;
    private $jobsCollection;

    public function __construct()
    {
        $this->search_api_url = config('torre.api.search_url');
        $this->members_api_url = config('torre.api.members_url');
        $this->jobs_api_url = config('torre.api.jobs_url');
        $this->jobsCollection = collect();
    }

    public function index ($offset = 0)
    {
        $this->getJobs($offset);
        // $this->getMembers();
        return new JobCollection($this->jobsCollection);
    }

    private function getJobs ($offset)
    {
        $jobsResponse = Http::post($this->search_api_url, [
            'size' => 4,
            'offset' => $offset
        ])['results'];
        $this->getJobDetails($jobsResponse);
    }

    private function getJobDetails ($jobsResponse)
    {
        foreach ($jobsResponse as $i => $job) {
            $detailedJob = Http::get($this->jobs_api_url . '/' . $job['id'])->json();
            $this->jobsCollection[$i] = collect(['job' => $job, 'detail' => $detailedJob ]);
        }
    }

    private function getMembers ()
    {
        // dd($this->jobsCollection);
        foreach ($this->jobsCollection as $i => $job) {
            $this->getMembersDetails($job['detail']['members'], $i);
        }
    }

    private function getMembersDetails ($members, $jobIndex)
    {
        //dd($members);
        foreach ($members as $i => $member) {
            $this->jobsCollection[$jobIndex]['memberDetail'] = Http::get($this->members_api_url . '/' . $member['person']['username'])->json();
        }
    }
}
