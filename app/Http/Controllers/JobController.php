<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;

class JobController extends Controller
{
    private $size = 4;
    private $search_api_url;
    private $members_api_url;
    private $jobs_api_url;

    public function __construct()
    {
        $this->search_api_url = config('torre.api.search_url');
        $this->members_api_url = config('torre.api.members_url');
        $this->jobs_api_url = config('torre.api.jobs_url');
    }

    public function index ($offset = 0)
    {
        $jobs = $this->getJobs($offset);
        return $this->getMembers($jobs);
    }

    private function getJobs ($offset)
    {
        $jobsResponse = Http::post($this->search_api_url, [
            'size' => $this->size,
            'offset' => $offset
        ]);

        return $this->getJobDetails($jobsResponse->body());
    }

    private function getJobDetails ($jobs)
    {
        foreach ($jobs->results as $i => $job) {
            $job->detail = Http::get($this->jobs_api_url . '/' . $job->id)->body();
        }

        return $jobs;
    }

    private function getMembers ($jobs)
    {
        foreach ($jobs->members as $i => $member) {
            $member->detail = Http::get($this->members_api_url . '/' . $member->username)->body();
        }

        return $jobs;
    }
}
