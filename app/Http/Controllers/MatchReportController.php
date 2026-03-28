<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchReport;
use App\Models\JobPosting;
use App\Models\Resume;
use App\Jobs\GenerateMatchReport;

class MatchReportController extends Controller
{
    public function index()
    {
        $matches = MatchReport::with(['jobPosting', 'resume'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        $resumes = Resume::where('user_id', auth()->id())->latest()->get();
        $jobs = JobPosting::latest()->get();

        if ($resumes->isEmpty()) {
            return redirect()->route('resumes.index')->with('error', 'Upload a resume first.');
        }

        if ($jobs->isEmpty()) {
            return redirect()->route('applications.index')->with('error', 'Add a job posting first.');
        }

        return view('matches.create', compact('resumes', 'jobs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'resume_id' => 'required|exists:resumes,id',
        ]);

        $matchReport = MatchReport::create([
            'user_id' => auth()->id(),
            'job_posting_id' => $request->job_posting_id,
            'resume_id' => $request->resume_id,
            'status' => 'pending',
            'match_score' => 0,
        ]);

        GenerateMatchReport::dispatch($matchReport);

        return redirect()->route('matches.show', $matchReport)->with('success', 'Generating report...');
    }

    public function show(MatchReport $matchReport)
    {
        if ($matchReport->user_id !== auth()->id()) {
            abort(403);
        }

        $matchReport->load(['jobPosting', 'resume']);

        return view('matches.show', compact('matchReport')); // Use the show.blade.php we made earlier
    }
}