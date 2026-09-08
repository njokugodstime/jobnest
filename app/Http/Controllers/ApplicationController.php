<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Candidate: apply to a job
    public function store(Request $request, JobListing $job)
    {
        if (auth()->user()->role !== 'candidate') {
            abort(403, 'Only candidates can apply to jobs.');
        }

        $existing = Application::where('job_listing_id', $job->id)
            ->where('candidate_id', auth()->id())
            ->exists();

        if ($existing) {
            return back()->with('error', 'You have already applied to this job.');
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'job_listing_id' => $job->id,
            'candidate_id' => auth()->id(),
            'cover_letter' => $validated['cover_letter'] ?? null,
            'resume_path' => $resumePath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    // Candidate: view their own applications
    public function myApplications()
    {
        if (auth()->user()->role !== 'candidate') {
            abort(403, 'Only candidates can view applications.');
        }

        $applications = Application::where('candidate_id', auth()->id())
            ->with('jobListing')
            ->latest()
            ->get();

        return view('applications.my-applications', compact('applications'));
    }

    // Employer: update application status
    public function updateStatus(Request $request, Application $application)
    {
        $job = $application->jobListing;

        if (auth()->user()->role !== 'employer' || $job->employer_id !== auth()->id()) {
            abort(403, 'You do not have permission to update this application.');
        }

        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated!');
    }
}