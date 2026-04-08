<?php

namespace App\Livewire;

use App\Models\JobPosting;
use App\Services\GroqCoverLetterService;
use Livewire\Component;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Title;

#[Title('Cover Letter Workspace')]
class CoverLetterEditor extends Component
{
    public JobPosting $jobPosting;
    public string $content = '';
    public bool $isGenerating = false;
    public string $errorMessage = '';
    public bool $showDeleteModal = false;

    // SaaS Configuration
    public int $dailyLimit = 5; // Reduced to 5 for Free Tier
    private int $burstLimit = 2;  // Max generations per minute per user

    public function mount(JobPosting $jobPosting)
    {
        if ($jobPosting->user_id !== auth()->id()) {
            abort(403);
        }

        $this->jobPosting = $jobPosting;
        $this->content = $this->formatLetterText($jobPosting->cover_letter ?? '');
    }

    private function formatLetterText(string $text): string
    {
        if (empty($text)) return '';
        $text = trim(str_replace(['**', '##', '#', '*'], '', $text));
        if (strpos($text, "\n\n") === false && strpos($text, "\n") !== false) {
            $text = str_replace("\n", "\n\n", $text);
        }
        return $text;
    }

    public function getCreditsRemainingProperty(): int
    {
        $dailyKey = 'cv-gen-daily:' . auth()->id();
        $attempts = RateLimiter::attempts($dailyKey);
        return max(0, $this->dailyLimit - $attempts);
    }

    public function generate(GroqCoverLetterService $service)
    {
        $userId = auth()->id();
        $minuteKey = 'cv-gen-min:' . $userId;
        $dailyKey = 'cv-gen-daily:' . $userId;

        if (RateLimiter::tooManyAttempts($dailyKey, $this->dailyLimit)) {
            $this->errorMessage = "You have exhausted your {$this->dailyLimit} daily AI generations. Please try again tomorrow.";
            $this->dispatch('toast', message: 'Daily limit reached.', type: 'error');
            return;
        }

        if (RateLimiter::tooManyAttempts($minuteKey, $this->burstLimit)) {
            $seconds = RateLimiter::availableIn($minuteKey);
            $this->errorMessage = "System cooling down. Please wait {$seconds} seconds to ensure high-quality generation.";
            $this->dispatch('toast', message: 'Generating too fast.', type: 'error');
            return;
        }

        $this->isGenerating = true;
        $this->errorMessage = '';

        try {
            if (empty(config('services.groq.api_key'))) {
                throw new Exception('GROQ_API_KEY is missing in your configuration.');
            }

            $resumeContent = null;
            $resumeSource = '';
            
            $latestMatch = $this->jobPosting->matchReports()->latest()->first();

            if ($latestMatch && $latestMatch->resume && !empty($latestMatch->resume->content_raw)) {
                $resumeContent = $latestMatch->resume->content_raw;
                $resumeSource = 'Targeted Match Resume';
            } else {
                $primaryResume = auth()->user()->resumes()->where('is_primary', true)->first();
                if ($primaryResume && !empty($primaryResume->content_raw)) {
                    $resumeContent = $primaryResume->content_raw;
                    $resumeSource = 'Primary Resume';
                }
            }

            if (empty($resumeContent)) {
                throw new Exception('No resume found. Please set a Primary Resume.');
            }

            if (empty($this->jobPosting->description)) {
                throw new Exception('Job description is missing. AI needs context.');
            }

            $strictContext = "Company: {$this->jobPosting->company}\nJob Title: {$this->jobPosting->title}\nDescription: {$this->jobPosting->description}\n\nCRITICAL AI INSTRUCTION: Output PLAIN TEXT ONLY. You MUST use double newlines (\\n\\n) between paragraphs to format it as a business letter.";

            $generatedText = $service->generate($resumeContent, $strictContext);
            $this->content = $this->formatLetterText($generatedText);

            RateLimiter::hit($minuteKey, 60);
            RateLimiter::hit($dailyKey, 86400);

            $this->dispatch('toast', message: "Draft generated using {$resumeSource}!", type: 'success');

        } catch (Exception $e) {
            Log::error('Cover Letter Gen Error: ' . $e->getMessage());
            $this->errorMessage = $e->getMessage();
            $this->dispatch('toast', message: 'Generation failed.', type: 'error');
        } finally {
            $this->isGenerating = false;
        }
    }

    public function save()
    {
        $this->validate(['content' => 'required|string']);
        $this->jobPosting->update(['cover_letter' => $this->content]);
        $this->dispatch('toast', message: 'Cover letter saved securely!', type: 'success');
    }

    public function executeDelete()
    {
        $this->jobPosting->update(['cover_letter' => null]);
        session()->flash('success', 'Cover letter draft discarded.');
        return redirect()->route('cover-letters.index');
    }

    public function render()
    {
        return view('livewire.cover-letter-editor');
    }
}