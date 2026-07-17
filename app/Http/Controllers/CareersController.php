<?php

namespace App\Http\Controllers;

use App\Models\JobListing;

class CareersController extends Controller
{
    public function index()
    {
        $jobs = JobListing::where('is_active', true)
            ->orderByDesc('posted_at')
            ->get();

        $departments = $jobs->pluck('department')->filter()->unique()->values();

        return view('careers', compact('jobs', 'departments'));
    }

    public function show(string $slug)
    {
        $job = JobListing::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $relatedJobs = JobListing::where('is_active', true)
            ->where('id', '!=', $job->id)
            ->when($job->department, fn ($query) => $query->where('department', $job->department))
            ->limit(3)
            ->get();

        return view('career-details', compact('job', 'relatedJobs'));
    }
}
