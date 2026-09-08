<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    // Public: list all open jobs
    public function index(Request $request)
    {
        $query = JobListing::where('status', 'open')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        $jobs = $query->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    // Public: show single job
    public function show(JobListing $job)
    {
        $job->load('employer');
        $hasApplied = false;

        if (auth()->check() && auth()->user()->role === 'candidate') {
            $hasApplied = $job->applications()->where('candidate_id', auth()->id())->exists();
        }

        return view('jobs.show', compact('job', 'hasApplied'));
    }

    // Employer: show create form
    public function create()
    {
        $this->authorizeEmployer();
        return view('jobs.create');
    }

    // Employer: store new job
    public function store(Request $request)
    {
        $this->authorizeEmployer();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,remote',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . uniqid();
        $validated['employer_id'] = auth()->id();
        $validated['status'] = 'open';

        JobListing::create($validated);

        return redirect()->route('jobs.my-listings')->with('success', 'Job posted successfully!');
    }

    // Employer: view their own listings
    public function myListings()
    {
        $this->authorizeEmployer();
        $jobs = JobListing::where('employer_id', auth()->id())->latest()->get();
        return view('jobs.my-listings', compact('jobs'));
    }

    // Employer: show edit form
    public function edit(JobListing $job)
    {
        $this->authorizeOwner($job);
        return view('jobs.edit', compact('job'));
    }

    // Employer: update job
    public function update(Request $request, JobListing $job)
    {
        $this->authorizeOwner($job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,remote',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'status' => 'required|in:open,closed',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.my-listings')->with('success', 'Job updated successfully!');
    }

    // Employer: delete job
    public function destroy(JobListing $job)
    {
        $this->authorizeOwner($job);
        $job->delete();
        return redirect()->route('jobs.my-listings')->with('success', 'Job deleted successfully!');
    }

    // Employer: view applicants for a job
    public function applicants(JobListing $job)
    {
        $this->authorizeOwner($job);
        $job->load('applications.candidate');
        return view('jobs.applicants', compact('job'));
    }

    private function authorizeEmployer()
    {
        if (auth()->user()->role !== 'employer') {
            abort(403, 'Only employers can perform this action.');
        }
    }

    private function authorizeOwner(JobListing $job)
    {
        $this->authorizeEmployer();
        if ($job->employer_id !== auth()->id()) {
            abort(403, 'You do not own this job listing.');
        }
    }
}