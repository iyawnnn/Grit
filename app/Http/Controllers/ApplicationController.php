<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchReport;
use App\Jobs\GenerateMatchReport;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $applications = MatchReport::with('jobPosting')
            ->where('user_id', $user->id)
            ->when($search, function ($query, $search) {
                $query->whereHas('jobPosting', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications', 'search'));
    }

    public function create()
    {
        // Fetch the user's resumes so they can select one in the form
        $resumes = Resume::where('user_id', auth()->id())->latest()->get();

        // If they have no resumes, force them to upload one first
        if ($resumes->isEmpty()) {
            return redirect()->route('resumes.index')
                ->with('error', 'Please upload a resume before creating a match report.');
        }

        return view('applications.create', compact('resumes'));
    }

    // Add this new method
    public function show(MatchReport $matchReport)
    {
        // Security check to ensure the user owns this report
        if ($matchReport->user_id !== auth()->id()) {
            abort(403);
        }

        // Load the related models so we can display their data
        $matchReport->load(['jobPosting', 'resume']);

        return view('applications.show', compact('matchReport'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'description' => 'required|string',
            'resume_id' => 'required|exists:resumes,id',
        ]);

        // 1. Create the Job Posting
        $jobPosting = JobPosting::create([
            'title' => $request->title,
            'company' => $request->company,
            'url' => $request->url,
            'description' => $request->description,
        ]);

        // 2. Create the initial pending Match Report
        $matchReport = \App\Models\MatchReport::create([
            'user_id' => auth()->id(),
            'job_posting_id' => $jobPosting->id,
            'resume_id' => $request->resume_id,
            'status' => 'pending',
            'match_score' => 0,
        ]);

        // 3. Dispatch your background job to analyze the resume against the job description
        GenerateMatchReport::dispatch($matchReport);

        return redirect()->route('applications.show', $matchReport)
            ->with('success', 'Application tracked! We are generating your match report now.');
    }
}