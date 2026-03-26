<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MatchAnalysisService
{
    public function analyze(Resume $resume, JobPosting $jobPosting): array
    {
        $cacheKey = 'match_report_' . $resume->id . '_' . $jobPosting->id;

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($resume, $jobPosting) {
            try {
                $apiKey = env('GROQ_API_KEY');
                if (!$apiKey) throw new \Exception('Missing API Key');

                $systemMessage = "You are a highly precise Applicant Tracking System. 
                Step 1: Extract ONLY hard technical skills, tools, programming languages, and formal methodologies from the Job Description. You MUST IGNORE company names (e.g., Cloudstaff), soft skills (e.g., motivated, team player), and job perks.
                Step 2: Evaluate the Resume for evidence of these exact technical requirements. Understand synonyms (e.g., AWS = Cloud Computing).
                Step 3: Return a JSON object with three keys: 
                - 'score': (0-100) integer.
                - 'missing_keywords': An array of ONLY the hard technical skills missing from the resume.
                - 'reasoning': A short 2-3 sentence explanation directed at the user, explaining exactly why they received this score, praising their matching skills, and highlighting their critical gaps.";

                $userMessage = "Resume:\n" . ($resume->content_raw ?? '') . "\n\nJob Description:\n" . ($jobPosting->description ?? '');

                $response = Http::withToken($apiKey)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(15)
                    ->post('https://api.groq.com/openai/v1/chat/completions', [
                        'model' => 'llama-3.3-70b-versatile',
                        'response_format' => ['type' => 'json_object'],
                        'messages' => [
                            ['role' => 'system', 'content' => $systemMessage],
                            ['role' => 'user', 'content' => $userMessage],
                        ],
                        'temperature' => 0.1
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
                    'missing_keywords' => $data['missing_keywords'] ?? [],
                    'reasoning' => $data['reasoning'] ?? 'No reasoning provided.'
                ];
            } catch (\Exception $e) {
                Log::error('Groq API error. Using offline fallback. Error: ' . $e->getMessage());
                return $this->offlineFallback($resume, $jobPosting);
            }
        });
    }

    private function offlineFallback(Resume $resume, JobPosting $jobPosting): array
    {
        $resumeText = strtolower($resume->content_raw ?? '');
        $jobText = strtolower($jobPosting->description ?? '');

        preg_match_all('/\b[a-zA-Z]{6,}\b/', $jobText, $matches);
        $jobWords = array_unique($matches[0]);

        $missingKeywords = [];
        $matchCount = 0;

        foreach ($jobWords as $word) {
            if (str_contains($resumeText, $word)) {
                $matchCount++;
            } else {
                if (count($missingKeywords) < 5) {
                    $missingKeywords[] = $word;
                }
            }
        }

        $totalWords = count($jobWords) > 0 ? count($jobWords) : 1;
        $score = ($matchCount / $totalWords) * 100;

        return [
            'score' => round($score),
            'missing_keywords' => array_merge(['(Offline Backup)'], $missingKeywords)
        ];
    }
}
