<?php

namespace App\Filament\Widgets;

use App\Models\JobPosting;
use App\Models\MatchReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class JobOverviewStats extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        // Strictly limit all calculations to the current user
        $totalJobs = JobPosting::where('user_id', $userId)->count();

        $averageScore = MatchReport::where('user_id', $userId)->avg('score') ?? 0;

        $interviewingCount = JobPosting::where('user_id', $userId)
            ->where('status', 'Interviewing')
            ->count();

        return [
            Stat::make('Total Opportunities', $totalJobs)
                ->description('Jobs in your pipeline')
                ->color('primary'),

            Stat::make('Average Match Score', number_format($averageScore, 0) . '%')
                ->description('Based on AI Gap Analysis')
                ->color('success'),

            Stat::make('Active Interviews', $interviewingCount)
                ->description('Currently interviewing')
                ->color('warning'),
        ];
    }
}