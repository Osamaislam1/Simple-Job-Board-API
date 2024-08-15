<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();

        if ($jobs->isEmpty()) {
            return response()->json([
                'message' => 'No jobs found'
            ], Response::HTTP_NOT_FOUND);
        }

        return JobResource::collection($jobs);
    }

    public function store(Request $request)
    {
        $validated = $this->validateJob($request);

        $job = Auth::user()->jobs()->create($validated);

        return (new JobResource($job))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Job $job)
    {
        return new JobResource($job);
    }

    public function update(Request $request, Job $job)
    {
        if ($this->isNotAuthorized($job)) {
            return $this->unauthorizedResponse();
        }

        $validated = $this->validateJob($request, $isUpdate = true);

        $job->update($validated);

        return new JobResource($job);
    }

    public function destroy(Job $job)
    {
        if ($this->isNotAuthorized($job)) {
            return $this->unauthorizedResponse();
        }

        $job->delete();

        return response()->json(['message' => 'Job deleted successfully'], Response::HTTP_OK);
    }

    public function search(Request $request)
    {
        $query = Job::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->get('location') . '%');
        }

        $jobs = $query->get();

        if ($jobs->isEmpty()) {
            return response()->json([
                'message' => 'No jobs found'
            ], Response::HTTP_NOT_FOUND);
        }

        return JobResource::collection($jobs);
    }

    private function validateJob(Request $request, $isUpdate = false)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
        ];

        if ($isUpdate) {
            $rules = array_map(fn($rule) => 'sometimes|' . $rule, $rules);
        }

        return $request->validate($rules);
    }

    private function isNotAuthorized(Job $job)
    {
        return Auth::id() !== $job->user_id;
    }

    private function unauthorizedResponse()
    {
        return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
    }
}
