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

                $systemMessage = "You are a highly intelligent, generalized Applicant Tracking System. Your absolute rule is to NEVER invent job requirements.

                Follow these steps strictly:
                1. Read the Job Description. Extract ONLY the hard skills, tools, and formal methodologies explicitly written in the text.
                2. Read the Resume. Evaluate if the extracted skills are present. You MUST apply semantic reasoning and common sense:
                   - Implied Foundations: If the resume lists an advanced skill or framework, you MUST automatically credit the candidate for the fundamental prerequisite skills required to perform it.
                   - Categorical Equivalents: If the job requires a broad category, demonstrating a specific tool within that category counts as a full match.
                
                You MUST return a JSON object with exactly these four keys:
                - 'extracted_requirements': An array of the exact skills found in the job text.
                - 'missing_keywords': An array of ONLY the extracted requirements that are completely missing (and not implied) from the resume.
                - 'score': An integer from 0 to 100 representing the exact match percentage.
                - 'reasoning': A 2 sentence explanation of the score. Do not mention company names. Focus on the exact skill matches and gaps.";

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
