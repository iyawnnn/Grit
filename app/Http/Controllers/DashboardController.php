<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\MatchReport;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalResumes = Resume::where('user_id', $user->id)->count();
        $totalMatches = MatchReport::where('user_id', $user->id)->count();
        $averageScore = MatchReport::where('user_id', $user->id)->avg('match_score') ?? 0;

        $recentActivity = MatchReport::where('user_id', $user->id)
            ->with('jobPosting')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalResumes',
            'totalMatches',
            'averageScore',
            'recentActivity'
        ));
    }
}