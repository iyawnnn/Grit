<?php

namespace App\Filament\Widgets;

use App\Models\JobPosting;
use App\Models\MatchReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JobOverviewStats extends BaseWidget
{
    // This makes the widget span the full width of the dashboard
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // 1. Calculate our metrics
        $totalJobs = JobPosting::count();
        $avgScore = MatchReport::avg('score') ?? 0;
        $interviewing = JobPosting::where('status', 'Interviewing')->count();

        // 2. Return the visual cards (Bento style)
        return [
            Stat::make('Total Opportunities', $totalJobs)
                ->description('Jobs in your pipeline')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),

            Stat::make('Average Match Score', round($avgScore) . '%')
                ->description('Based on AI Gap Analysis')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'), // Using warning gives us that Claude Orange look

            Stat::make('Interview Pipeline', $interviewing)
                ->description('Active interviews')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
        ];
    }
}