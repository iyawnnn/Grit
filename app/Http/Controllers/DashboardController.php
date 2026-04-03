<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\MatchReport;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Basic counts
        $totalResumes = Resume::where('user_id', $user->id)->count();
        $totalReports = MatchReport::where('user_id', $user->id)->count();

        // 2. Average match score
        $averageScore = MatchReport::where('user_id', $user->id)->avg('score') ?? 0;
        $averageScore = round($averageScore);

        // 3. Fetch recent reports for the list (Feed)
        $recentReports = MatchReport::with(['jobPosting', 'resume'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // 4. Fetch trend data for the chart (last 7 reports)
        $trendReports = MatchReport::with(['jobPosting'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(7)
            ->get()
            ->reverse()
            ->values();

        $chartLabels = $trendReports->map(fn($r) => $r->created_at->format('M d'))->toArray();
        $chartData = $trendReports->pluck('score')->toArray();
        
        // Truncate job titles for clean tooltips
        $chartTooltips = $trendReports->map(fn($r) => Str::limit($r->jobPosting->title ?? 'Unknown Job', 30))->toArray();

        // 5. Intelligent Readiness Metric & Insights
        $readiness = 0;
        $readinessMessage = "";
        $readinessSubtext = "";

        if ($totalResumes === 0 && $totalReports === 0) {
            $readiness = 0;
            $readinessMessage = "Awaiting Data";
            $readinessSubtext = "Upload your first resume to establish your baseline.";
        } elseif ($totalResumes > 0 && $totalReports === 0) {
            $readiness = 20;
            $readinessMessage = "Baseline Established";
            $readinessSubtext = "Run your first match report to calibrate your true readiness score.";
        } else {
            // Formula: 40 base points + up to 60 points based on their average score
            $readiness = 40 + ($averageScore * 0.6); 
            $readiness = min(100, round($readiness));
            
            if ($readiness < 60) {
                $readinessMessage = "Needs Optimization";
                $readinessSubtext = "Your tailored resumes need more alignment with the jobs you are targeting.";
            } elseif ($readiness < 85) {
                $readinessMessage = "Strong Contender";
                $readinessSubtext = "You are matching well. Keep refining your keywords to reach the top tier.";
            } else {
                $readinessMessage = "Highly Optimized";
                $readinessSubtext = "Your application materials are exceptionally aligned. You are ready to apply.";
            }
        }

        return view('dashboard.index', compact(
            'totalResumes',
            'totalReports',
            'averageScore',
            'recentReports',
            'readiness',
            'readinessMessage',
            'readinessSubtext',
            'chartLabels',
            'chartData',
            'chartTooltips'
        ));
    }
}