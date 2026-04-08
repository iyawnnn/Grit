<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class GroqFormatterService
{
    public function formatJobDescription(string $rawText): string
    {
        $apiKey = config('services.groq.api_key');

        if (empty($apiKey)) {
            throw new Exception('GROQ_API_KEY is not configured.');
        }

        $systemPrompt = "You are an expert data formatting assistant. Your task is to take messy, unformatted text from a job posting and format it into clean, semantic HTML. "
            . "You must strictly use only <p>, <ul>, <li>, <strong>, and <br> tags. "
            . "Ensure headings are bolded. Ensure lists are properly formatted using <ul> and <li>. "
            . "Correct any obvious spacing or line-break issues. "
            . "CRITICAL INSTRUCTION: You must return ONLY the raw HTML string. Do not use markdown blocks, do not wrap the output in ```html, and do not include any conversational text like 'Here is the formatted text'.";

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('[https://api.groq.com/openai/v1/chat/completions](https://api.groq.com/openai/v1/chat/completions)', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $rawText],
                ],
                'temperature' => 0.1,
            ]);

        if ($response->failed()) {
            throw new Exception('Failed to format the text via Groq API. ' . $response->body());
        }

        $result = $response->json('choices.0.message.content');

        return trim(str_replace(['```html', '```'], '', $result));
    }
}