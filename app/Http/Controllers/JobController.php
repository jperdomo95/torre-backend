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
        // Log::info($this->search_api_url);
        return Http::post($this->search_api_url);
    }

    private function getJobs ()
    {

    }

    private function getJobDetails ()
    {

    }

    private function getMembers ()
    {

    }

    private function getMemberDetails ()
    {

    }
}
