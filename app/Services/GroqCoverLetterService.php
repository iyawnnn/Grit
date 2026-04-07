<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqCoverLetterService
{
    public function generate(string $resumeContent, string $jobContext): string
    {
        $apiKey = config('services.groq.api_key');

        if (empty($apiKey)) {
            Log::error('Groq API Key is missing from configuration.');
            throw new Exception('Groq API key is missing. Please check your configuration.');
        }

        $prompt = config('services.groq.cover_letter_prompt', 'You are an expert career coach. Based on the provided resume and job context, write a concise, professional cover letter. Return the output strictly as a JSON object with a single key "cover_letter" containing the text.');

        $response = Http::withToken($apiKey)
            ->timeout(60)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => "Resume: \n" . $resumeContent . "\n\nJob Context: \n" . $jobContext],
                ],
                'response_format' => ['type' => 'json_object'],
            ]);

        if ($response->failed()) {
            Log::error('Groq API Error (Cover Letter): ' . $response->body());
            throw new Exception('Failed to connect to Groq AI. Please try again later.');
        }

        $content = $response->json('choices.0.message.content');
        $decoded = json_decode($content, true);

        return $decoded['cover_letter'] ?? 'Failed to generate content.';
    }
}