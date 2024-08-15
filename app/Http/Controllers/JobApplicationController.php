<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobApplicationResource;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JobApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $application = JobApplication::create([
            'user_id' => Auth::id(),
            'job_id' => $validated['job_id'],
        ]);

        $application->load('user', 'job');

        return (new JobApplicationResource($application))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function indexByJob($jobId)
    {
        $applications = $this->getApplications(['job_id' => $jobId]);

        return JobApplicationResource::collection($applications);
    }

    public function indexByUser()
    {
        $applications = $this->getApplications(['user_id' => Auth::id()]);

        return JobApplicationResource::collection($applications);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);
    }

    private function getApplications(array $conditions)
    {
        return JobApplication::where($conditions)
            ->with('user', 'job')
            ->get();
    }
}
