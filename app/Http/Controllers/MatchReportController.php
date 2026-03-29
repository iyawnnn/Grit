<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Jobs\GenerateMatchReport;
use Illuminate\Support\Facades\Cache;

class MatchReportController extends Controller
{
    public function index()
    {
        $cacheKey = 'user_' . auth()->id() . '_matches_page_' . request('page', 1);

        // Changed variable name from $matchReports to $matches
        $matches = Cache::remember($cacheKey, 3600, function () {
            return MatchReport::with(['resume', 'jobPosting'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10);
        });

        // Compact now sends 'matches' to the view
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

        // Create a unique SHA-256 fingerprint from the combined text content
        $contentToHash = $resume->content . $jobPosting->description;
        $fingerprint = hash('sha256', $contentToHash);
        $cacheKey = 'match_report_hash_' . $fingerprint;

        // Check if this exact analysis has already been completed
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

        // Save the fingerprint mapping to the cache for 30 days
        Cache::put($cacheKey, $matchReport->id, now()->addDays(30));
        $this->clearMatchesCache();

        GenerateMatchReport::dispatch($matchReport);

        return redirect()->route('matches.show', $matchReport)
            ->with('success', 'Your match report is being generated.');
    }

    public function show(MatchReport $matchReport)
    {
        if ($matchReport->user_id !== auth()->id()) {
            abort(403);
        }

        return view('matches.show', compact('matchReport'));
    }

    public function destroy(MatchReport $matchReport)
    {
        if ($matchReport->user_id !== auth()->id()) {
            abort(403);
        }

        $matchReport->delete();
        $this->clearMatchesCache();

        return redirect()->route('matches.index')->with('success', 'Report deleted successfully.');
    }

    private function clearMatchesCache()
    {
        $userId = auth()->id();

        for ($i = 1; $i <= 10; $i++) {
            Cache::forget('user_' . $userId . '_matches_page_' . $i);
        }
    }
}