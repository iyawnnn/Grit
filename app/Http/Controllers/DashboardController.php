<?php

namespace App\Http\Controllers;

use App\Models\MatchReport;
use App\Models\Resume;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalResumes = Resume::where('user_id', $user->id)->count();

        // Calculate total reports and average score in one database trip
        $reportStats = MatchReport::where('user_id', $user->id)
            ->selectRaw('
                count(*) as total_reports,
                avg(score) as average_score
            ')->first();

        $totalReports = (int) ($reportStats->total_reports ?? 0);
        $averageScore = round((float) ($reportStats->average_score ?? 0));

        // Fetch up to 7 reports once and reuse the data for both recent list and chart
        $baseReports = MatchReport::with(['jobPosting', 'resume'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(7)
            ->get();

        $recentReports = $baseReports->take(3);
        $trendReports = $baseReports->reverse()->values();

        $chartLabels = $trendReports->map(fn ($r) => $r->created_at->format('M d'))->toArray();
        $chartData = $trendReports->pluck('score')->toArray();

        $chartTooltips = $trendReports->map(fn ($r) => Str::limit($r->jobPosting->title ?? 'Unknown Job', 30))->toArray();

        $readiness = 0;
        $readinessMessage = '';
        $readinessSubtext = '';

        if ($totalResumes === 0 && $totalReports === 0) {
            $readiness = 0;
            $readinessMessage = 'Awaiting Data';
            $readinessSubtext = 'Upload your first resume to establish your baseline.';
        } elseif ($totalResumes > 0 && $totalReports === 0) {
            $readiness = 20;
            $readinessMessage = 'Baseline Established';
            $readinessSubtext = 'Run your first match report to calibrate your true readiness score.';
        } else {
            $readiness = 40 + ($averageScore * 0.6);
            $readiness = min(100, round($readiness));

            if ($readiness < 60) {
                $readinessMessage = 'Needs Optimization';
                $readinessSubtext = 'Your tailored resumes need more alignment with the jobs you are targeting.';
            } elseif ($readiness < 85) {
                $readinessMessage = 'Strong Contender';
                $readinessSubtext = 'You are matching well. Keep refining your keywords to reach the top tier.';
            } else {
                $readinessMessage = 'Highly Optimized';
                $readinessSubtext = 'Your application materials are exceptionally aligned. You are ready to apply.';
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
