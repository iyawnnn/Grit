<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MatchAnalysisService
{
    public function analyze(Resume $resume, JobPosting $jobPosting): array
    {
        try {
            $apiKey = env('GROQ_API_KEY');
            if (!$apiKey) throw new \Exception('Missing API Key');

            $systemMessage = "You are a strict applicant tracking system. Step 1: Extract required skills from the Job Description. Step 2: Scan the Resume for these exact skills. Step 3: Return a JSON object with 'score' (0-100) and 'missing_keywords'. The 'missing_keywords' array MUST ONLY contain skills required by the job that are COMPLETELY ABSENT from the resume. If a skill is on the resume, do not list it.";

            $userMessage = "Resume:\n" . ($resume->content_raw ?? '') . "\n\nJob Description:\n" . ($jobPosting->description ?? '');

            $response = Http::withToken($apiKey)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->timeout(10)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => $systemMessage],
                        ['role' => 'user', 'content' => $userMessage],
                    ]
                ]);

            if ($response->failed()) {
                throw new \Exception('API Call Failed: ' . $response->body());
            }

            $data = json_decode($response->json('choices.0.message.content') ?? '{}', true);
            
            if (!isset($data['score'])) {
                throw new \Exception('Invalid JSON from AI');
            }

            return [
                'score' => (int) $data['score'],
                'missing_keywords' => $data['missing_keywords'] ?? []
            ];

        } catch (\Exception $e) {
            Log::error('Groq API error. Using offline fallback. Error: ' . $e->getMessage());
            return $this->offlineFallback($resume, $jobPosting);
        }
    }

    // THE OFFLINE BACKUP ENGINE
    private function offlineFallback(Resume $resume, JobPosting $jobPosting): array
    {
        $resumeText = strtolower($resume->content_raw ?? '');
        $jobText = strtolower($jobPosting->description ?? '');

        $masterKeywords = ['HTML', 'CSS', 'JavaScript', 'React', 'Vue', 'Angular', 'Node.js', 'Express', 'PHP', 'Laravel', 'Python', 'Java', 'MongoDB', 'MySQL', 'PostgreSQL', 'AWS', 'SEO'];
        
        $jobRequirements = [];
        $missingKeywords = [];

        foreach ($masterKeywords as $keyword) {
            if (str_contains($jobText, strtolower($keyword))) $jobRequirements[] = $keyword;
        }

        if (empty($jobRequirements)) return ['score' => 100, 'missing_keywords' => []];

        foreach ($jobRequirements as $keyword) {
            if (!str_contains($resumeText, strtolower($keyword))) $missingKeywords[] = $keyword;
        }

        $score = ((count($jobRequirements) - count($missingKeywords)) / count($jobRequirements)) * 100;

        return [
            'score' => round($score),
            'missing_keywords' => array_merge(['(Offline Mode)'], $missingKeywords) // Adds a tag so you know it used the backup
        ];
    }
}