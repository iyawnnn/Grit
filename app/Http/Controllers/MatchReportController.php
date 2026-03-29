<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Jobs\GenerateMatchReport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class MatchReportController extends Controller
{
    public function index()
    {
        $matches = MatchReport::with(['resume', 'jobPosting'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        $resumes = Resume::where('user_id', auth()->id())->get();
        $jobPostings = JobPosting::latest()->get();

        return view('matches.create', compact('resumes', 'jobPostings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resume_id' => 'required|exists:resumes,id',
            'job_posting_id' => 'required|exists:job_postings,id',
        ]);

        $resume = Resume::findOrFail($request->resume_id);
        $jobPosting = JobPosting::findOrFail($request->job_posting_id);

        $contentToHash = $resume->content . $jobPosting->description;
        $fingerprint = hash('sha256', $contentToHash);
        $cacheKey = 'match_report_hash_' . $fingerprint;

        if (Cache::has($cacheKey)) {
            $existingReportId = Cache::get($cacheKey);
            $existingReport = MatchReport::find($existingReportId);

            if ($existingReport) {
                return redirect()->route('matches.show', $existingReport)
                    ->with('success', 'We loaded your previously generated report to save time.');
            }
        }

        $matchReport = MatchReport::create([
            'user_id' => auth()->id(),
            'resume_id' => $resume->id,
            'job_posting_id' => $jobPosting->id,
            'status' => 'processing',
        ]);

        Cache::put($cacheKey, $matchReport->id, now()->addDays(30));

        GenerateMatchReport::dispatch($matchReport);

        return redirect()->route('matches.show', $matchReport)
            ->with('success', 'Your match report is being generated.');
    }

    public function show(MatchReport $matchReport)
    {
        Gate::authorize('view', $matchReport);

        return view('matches.show', compact('matchReport'));
    }

    public function updateStatus(Request $request, MatchReport $matchReport)
    {
        Gate::authorize('update', $matchReport);

        $request->validate([
            'status' => 'required|in:pending,applied,interviewing,offered,rejected',
        ]);

        $matchReport->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function destroy(MatchReport $matchReport)
    {
        Gate::authorize('delete', $matchReport);

        $matchReport->delete();

        return redirect()->route('matches.index')->with('success', 'Report deleted successfully.');
    }
}