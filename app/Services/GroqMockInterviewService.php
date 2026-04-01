<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GroqMockInterviewService
{
    public function generateQuestions(string $resumeContent, string $jobDescription): array
    {
        $prompt = "You are an expert technical recruiter. Based on the following resume and job description, generate 5 interview questions. Include 3 technical questions and 2 behavioral questions. Return the output strictly as a JSON array of strings.";

        $response = Http::withToken(config('services.groq.key'))
            ->timeout(30)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-70b-8192',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => "Resume: " . $resumeContent . "\n\nJob: " . $jobDescription],
                ],
                'response_format' => ['type' => 'json_object'],
            ]);

        if ($response->failed()) {
            throw new Exception('Failed to connect to the Groq API.');
        }

        $content = $response->json('choices.0.message.content');
        $decoded = json_decode($content, true);

        return $decoded['questions'] ?? $decoded; 
    }
}