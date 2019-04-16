<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use App\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['show']);
    }

    public function index()
    {

    }

    public function store(JobRequest $request)
    {
        $job = Job::create(array_merge($request->all(), ['company_id' => auth()->user()->company->id]));
        return $this->show($job->id);
    }

    public function show($companyId)
    {
        $job = Job::where('id', $companyId)->first();
        return new JobResource($job);
    }

    public function update(Request $request, Job $job)
    {
        // TODO 验证用户是否有 权限
        $job->update($request->all());
        return new JobResource($job);
    }
}
