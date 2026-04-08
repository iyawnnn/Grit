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

        $systemPrompt = "You are an expert data formatting assistant. Your task is to clean and structure messy job posting text into semantic HTML. "
            . "CRITICAL FORMATTING RULES: "
            . "1. STRICTLY use ONLY these tags: <p>, <ul>, <li>, and <strong>. DO NOT use <br> tags under any circumstances. "
            . "2. ELIMINATE ALL excessive whitespace. Do not output empty tags like <p></p> or multiple consecutive line breaks. "
            . "3. Aggressively identify lists (lines starting with dashes, asterisks, bullets, or short consecutive requirements) and format them properly using <ul> and <li> tags. "
            . "4. Identify section headers (e.g., 'Responsibilities', 'Requirements', 'Qualifications') and format them strictly as <p><strong>Header Name</strong></p>. "
            . "5. You must return ONLY the raw HTML string. Do not use markdown blocks, do not wrap the output in ```html, and do not include any conversational text.";

        // Breaking the URL into pieces so your clipboard/editor cannot auto-format it into a markdown link
        $endpoint = 'https://' . 'api.groq.com' . '/openai/v1/chat/completions';

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post($endpoint, [
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