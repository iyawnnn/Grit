<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class CreateApplication extends Component
{
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $company = '';

    #[Validate('nullable|url|max:255')]
    public $url = '';

    #[Validate('required|string')]
    public $description = '';

    public function formatJobDescription()
    {
        if (empty($this->description)) {
            return;
        }

        // We explicitly command the AI to remove empty space and enforce lists
        $prompt = "Take this raw job description and format it into clean, tight HTML suitable for a rich text editor.\n" .
                  "1. Use <h1> for main section headers like 'Requirements' or 'Responsibilities'.\n" .
                  "2. You MUST use <ul> and <li> for lists. Convert any hyphenated lines or comma-separated requirements into proper bullet points.\n" .
                  "3. Use <strong> to highlight key skills and technologies.\n" .
                  "4. CRITICAL: Remove all unnecessary whitespace, double line breaks, and empty HTML tags. Minify the output to prevent huge gaps.\n\n" .
                  "Original Text:\n" . $this->description . "\n\n" .
                  "You MUST respond ONLY with a valid JSON object using this exact schema:\n" .
                  "{\n" .
                  "  \"formatted_text\": \"The clean, tightly spaced HTML text goes here.\"\n" .
                  "}";

        try {
            $response = Http::withToken(config('services.groq.api_key'))
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    // Changed to the slightly faster 8b model for simple formatting tasks
                    'model' => 'llama3-8b-8192',
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are an HTML formatter. You remove all unnecessary spacing and output valid JSON.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.1,
                    'max_tokens' => 1500,
                ]);

            if ($response->successful()) {
                $data = $response->json('choices.0.message.content');
                $decoded = json_decode($data, true);
                
                if (isset($decoded['formatted_text'])) {
                    $this->description = $decoded['formatted_text'];
                }
            }
        } catch (Exception $e) {
            Log::error('Groq Formatting Error: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        JobPosting::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'company' => $this->company,
            'source_url' => $this->url, 
            'description' => $this->description,
        ]);

        session()->flash('success', 'Job posting saved successfully.');

        return redirect()->route('applications.index');
    }

    public function render()
    {
        return view('livewire.create-application');
    }
}