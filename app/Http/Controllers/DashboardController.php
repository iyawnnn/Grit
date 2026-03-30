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

        // 1. Get the basic counts
        $totalResumes = Resume::where('user_id', $user->id)->count();
        $totalReports = MatchReport::where('user_id', $user->id)->count();

        // 2. Calculate the average match score safely
        $averageScore = MatchReport::where('user_id', $user->id)->avg('score') ?? 0;
        $averageScore = round($averageScore);

        // 3. Fetch the 5 most recent reports to show in the list
        $recentReports = MatchReport::with(['jobPosting', 'resume'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // 4. Calculate a dynamic Profile Strength metric
        // Base 20%, +20% for having a resume, +20% for running a report, plus a bonus based on average score
        $profileStrength = 20;
        if ($totalResumes > 0)
            $profileStrength += 20;
        if ($totalReports > 0)
            $profileStrength += 20;
        $profileStrength += ($averageScore * 0.4);
        $profileStrength = min(100, round($profileStrength));

        return view('dashboard', compact(
            'totalResumes',
            'totalReports',
            'averageScore',
            'recentReports',
            'profileStrength'
        ));
    }
}