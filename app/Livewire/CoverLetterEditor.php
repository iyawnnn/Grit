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

    public function generate(GroqCoverLetterService $service)
    {
        $rateLimitKey = 'generate-cover-letter:' . auth()->id() . ':' . $this->jobPosting->id;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $this->errorMessage = "Please wait {$seconds} seconds before regenerating.";
            $this->dispatch('notify', message: 'Rate limit exceeded.', type: 'error');
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
                $resumeSource = 'Targeted Resume';
            } else {
                $primaryResume = auth()->user()->resumes()->where('is_primary', true)->first();
                if ($primaryResume && !empty($primaryResume->content_raw)) {
                    $resumeContent = $primaryResume->content_raw;
                    $resumeSource = 'Primary Resume';
                }
            }

            if (empty($resumeContent)) {
                throw new Exception('No resume found. Please generate a Match Report or set a Primary Resume.');
            }

            if (empty($this->jobPosting->description)) {
                throw new Exception('Job description is missing. The AI needs this context.');
            }

            $strictContext = "Company: {$this->jobPosting->company}\nJob Title: {$this->jobPosting->title}\nDescription: {$this->jobPosting->description}\n\nCRITICAL AI INSTRUCTION: Output PLAIN TEXT ONLY. You MUST use double newlines (\\n\\n) between paragraphs to format it as a business letter.";

            $generatedText = $service->generate($resumeContent, $strictContext);
            $this->content = $this->formatLetterText($generatedText);

            // Successfully notify the user asynchronously 
            $this->dispatch('notify', message: "Draft generated using {$resumeSource}!", type: 'success');
            RateLimiter::hit($rateLimitKey, 60);

        } catch (Exception $e) {
            Log::error('Cover Letter Gen Error: ' . $e->getMessage());
            $this->errorMessage = $e->getMessage();
            $this->dispatch('notify', message: 'Generation failed.', type: 'error');
        } finally {
            $this->isGenerating = false;
        }
    }

    public function save()
    {
        $this->validate([
            'content' => 'required|string',
        ]);

        $this->jobPosting->update([
            'cover_letter' => $this->content
        ]);

        // Triggers the application's global toast listener without refreshing
        $this->dispatch('notify', message: 'Cover letter saved successfully.', type: 'success');
    }

    public function executeDelete()
    {
        $this->jobPosting->update(['cover_letter' => null]);
        session()->flash('success', 'Cover letter draft deleted successfully.');
        return redirect()->route('cover-letters.index');
    }

    public function render()
    {
        return view('livewire.cover-letter-editor');
    }
}