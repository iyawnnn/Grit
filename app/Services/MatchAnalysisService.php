<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\JobPosting;

class MatchAnalysisService
{
    public function analyze(Resume $resume, JobPosting $jobPosting): array
    {
        // Convert both texts to lowercase so "React" matches "react"
        $resumeText = strtolower($resume->content_raw ?? '');
        $jobText = strtolower($jobPosting->description ?? '');

        // 1. Our Master Dictionary of Tech Skills
        $masterKeywords = [
            'HTML', 'CSS', 'JavaScript', 'React', 'Vue', 'Angular', 'Node.js', 
            'Express', 'PHP', 'Laravel', 'Python', 'Java', 'MongoDB', 'MySQL', 
            'PostgreSQL', 'AWS', 'Docker', 'SEO', 'TypeScript', 'Tailwind', 'APIs'
        ];

        $jobRequirements = [];
        $missingKeywords = [];

        // 2. What does the JOB actually ask for?
        foreach ($masterKeywords as $keyword) {
            if (str_contains($jobText, strtolower($keyword))) {
                $jobRequirements[] = $keyword;
            }
        }

        // If the job description is empty or has no tech words, give a perfect score
        if (count($jobRequirements) === 0) {
            return [
                'score' => 100,
                'missing_keywords' => []
            ];
        }

        // 3. Which of those job requirements are MISSING from the Resume?
        foreach ($jobRequirements as $keyword) {
            if (!str_contains($resumeText, strtolower($keyword))) {
                $missingKeywords[] = $keyword;
            }
        }

        // 4. Calculate the real math
        $matchedCount = count($jobRequirements) - count($missingKeywords);
        $score = ($matchedCount / count($jobRequirements)) * 100;

        return [
            'score' => round($score),
            'missing_keywords' => $missingKeywords
        ];
    }
}