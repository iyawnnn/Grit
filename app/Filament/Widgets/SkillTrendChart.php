<?php

namespace App\Filament\Widgets;

use App\Models\MatchReport;
use Filament\Widgets\ChartWidget;

class SkillTrendChart extends ChartWidget
{
    protected ?string $heading = 'Skill Trend Analyzer (What to Learn Next)';
    
    // Sort the widget so it appears below your stats cards
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        // 1. Get all match reports for the logged in user
        $reports = MatchReport::where('user_id', auth()->id())->get();
        
        $allKeywords = [];

        // 2. Loop through every report and collect the missing keywords
        foreach ($reports as $report) {
            $keywords = $report->missing_keywords ?? [];
            
            // Sometimes JSON is stored as a string, let us make sure it is an array
            if (is_string($keywords)) {
                $keywords = json_decode($keywords, true) ?? [];
            }
            
            // Normalize words so "React" and "react" are counted together
            $normalized = array_map(function($word) {
                return ucwords(strtolower(trim($word)));
            }, $keywords);

            $allKeywords = array_merge($allKeywords, $normalized);
        }

        // 3. Count how many times each skill appears and sort them
        $counts = array_count_values($allKeywords);
        arsort($counts);
        
        // 4. Grab the top 5 most frequently missing skills
        $topSkills = array_slice($counts, 0, 5, true);

        return [
            'datasets' => [
                [
                    'label' => 'Times Requested in Job Postings',
                    'data' => array_values($topSkills),
                    // We use an orange color to match your branding
                    'backgroundColor' => '#D97706',
                ],
            ],
            'labels' => array_keys($topSkills),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}