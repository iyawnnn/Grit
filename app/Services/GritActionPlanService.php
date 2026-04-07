<?php

namespace App\Services;

use App\Models\MatchReport;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GritActionPlanService
{
    public function generatePlan(MatchReport $matchReport): ?string
    {
        // Handle both Laravel array casts and raw JSON strings
        $keywords = is_string($matchReport->missing_keywords)
            ? json_decode($matchReport->missing_keywords, true)
            : ($matchReport->missing_keywords ?? []);

        if (empty($keywords)) {
            return json_encode([
                'steps' => [
                    [
                        'title' => 'Great Job!',
                        'actions' => ['You already meet all the key requirements for this role. Keep up the great work!'],
                    ],
                ],
            ]);
        }

        $prompt = 'You are an expert career mentor. The user is missing these skills: '.implode(', ', $keywords).".\n\n".
                  "Create a 3-step action plan to learn these skills. You MUST respond ONLY in valid JSON format.\n".
                  "Use this exact schema:\n".
                  "{\n".
                  "  \"steps\": [\n".
                  "    {\n".
                  "      \"title\": \"Step 1: [Actionable Title]\",\n".
                  "      \"actions\": [\n".
                  "        \"First actionable advice. Use **bold text** for tools.\",\n".
                  "        \"Second actionable advice. Use **bold text** for concepts.\"\n".
                  "      ]\n".
                  "    }\n".
                  "  ]\n".
                  '}';

        $response = Http::withToken(config('services.groq.api_key'))
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a strict data formatter. Always output valid JSON.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.2,
                'max_tokens' => 500,
            ]);

        if ($response->successful()) {
            $plan = $response->json('choices.0.message.content');

            $matchReport->update([
                'action_plan' => $plan,
            ]);

            return $plan;
        }

        Log::error('Groq Action Plan Error: '.$response->body());

        throw new Exception('Failed to generate action plan from Groq API.');
    }
}
