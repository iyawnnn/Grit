<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchReport;
use App\Services\MatchAnalysisService;
use Illuminate\Support\Facades\Gate;

class MatchReportController extends Controller
{
    public function index()
    {
        return view('matches.index');
    }

    public function create()
    {
        return view('matches.create');
    }

    public function store(Request $request, MatchAnalysisService $matchService)
    {
        $request->validate([
            'resume_id'      => 'required|exists:resumes,id',
            'job_posting_id' => 'required|exists:job_postings,id',
        ]);

        $result = $matchService->findOrCreateReport(
            (int) $request->resume_id,
            (int) $request->job_posting_id,
            (int) auth()->id()
        );

        $message = $result['is_cached']
            ? 'We loaded your previously generated report to save time.'
            : 'Your match report is being generated.';

        return redirect()->route('matches.show', $result['report'])->with('success', $message);
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