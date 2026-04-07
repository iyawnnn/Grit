<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqMockInterviewService
{
    public function generateQuestions(string $resumeContent, string $jobDescription): array
    {
        $apiKey = config('services.groq.api_key');

        if (empty($apiKey)) {
            Log::error('Groq API Key is completely missing from configuration.');
            throw new Exception('Groq API key is missing. Please check your .env file.');
        }

        $prompt = "You are an expert technical recruiter. Based on the following resume and job description, generate 5 interview questions. Include 3 technical questions and 2 behavioral questions. Return the output strictly as a JSON object with a single key 'questions' containing an array of strings.";

        $response = Http::withToken($apiKey)
            ->timeout(60)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => "Resume: \n".$resumeContent."\n\nJob Description: \n".$jobDescription],
                ],
                'response_format' => ['type' => 'json_object'],
            ]);

        if ($response->failed()) {
            Log::error('Groq API Error: '.$response->body());
            throw new Exception('Groq API Error: '.$response->status());
        }

        $content = $response->json('choices.0.message.content');
        $decoded = json_decode($content, true);

        return $decoded['questions'] ?? [];
    }
}
