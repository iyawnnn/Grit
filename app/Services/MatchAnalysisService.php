<?php

namespace App\Services;

use App\Models\JobPosting;
use App\Models\Resume;

class MatchAnalysisService
{
    /**
     * Define a list of Technical Keywords for case-insensitive matching.
     */
    protected array $technicalKeywords = [
        'PHP', 'Laravel', 'JavaScript', 'React', 'Vue', 'Tailwind',
        'SQL', 'MySQL', 'PostgreSQL', 'AWS', 'Python', 'Docker',
        'Node', 'HTML', 'CSS', 'Git', 'Redis', 'API', 'REST', 'GraphQL'
    ];

    public function analyze(Resume $resume, JobPosting $jobPosting): array
    {
        $jobText = $jobPosting->description ?? '';
        $resumeText = $resume->content_raw ?? '';

        $jobKeywordsPresent = [];

        // 1. Identify which keywords are present in the Job Description
        foreach ($this->technicalKeywords as $keyword) {
            if (stripos($jobText, $keyword) !== false) {
                $jobKeywordsPresent[] = $keyword;
            }
        }

        // If no keywords exist in job, we'll assume a 100% score (or could be 0, but 100 prevents penalizing).
        if (count($jobKeywordsPresent) === 0) {
            return [
                'score' => 100,
                'missing_keywords' => []
            ];
        }

        $missingKeywords = [];
        $matchedCount = 0;

        // 2. Check which of those "Job Keywords" are missing from the Resume text
        foreach ($jobKeywordsPresent as $keyword) {
            if (stripos($resumeText, $keyword) !== false) {
                $matchedCount++;
            } else {
                $missingKeywords[] = $keyword;
            }
        }

        // 3. Calculate score based on percentage
        $score = (int) round(($matchedCount / count($jobKeywordsPresent)) * 100);

        return [
            'score' => $score,
            'missing_keywords' => $missingKeywords,
        ];
    }
}
