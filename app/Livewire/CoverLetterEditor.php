<?php

namespace App\Livewire;

use App\Models\JobPosting;
use App\Services\GroqCoverLetterService;
use Livewire\Component;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;

#[Title('Edit Cover Letter')]
class CoverLetterEditor extends Component
{
    public JobPosting $jobPosting;
    public string $content = '';
    public bool $isGenerating = false;
    public string $errorMessage = '';

    public function mount(JobPosting $jobPosting)
    {
        if ($jobPosting->user_id !== auth()->id()) {
            abort(403);
        }

        $this->jobPosting = $jobPosting;
        $this->content = $jobPosting->cover_letter ?? '';
    }

    public function generate(GroqCoverLetterService $service)
    {
        $this->isGenerating = true;
        $this->errorMessage = '';

        try {
            if (empty(config('services.groq.api_key'))) {
                throw new Exception('GROQ_API_KEY is missing in your configuration.');
            }

            $resumeContent = null;
            $resumeSource = '';
            
            // Priority: Match Report Resume -> Primary Resume
            $latestMatch = $this->jobPosting->matchReports()->latest()->first();

            if ($latestMatch && $latestMatch->resume && !empty($latestMatch->resume->content_raw)) {
                $resumeContent = $latestMatch->resume->content_raw;
                $resumeSource = 'Targeted Resume (Match Report)';
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

            $this->content = $service->generate(
                $resumeContent,
                "Company: {$this->jobPosting->company}\nJob Title: {$this->jobPosting->title}\nDescription: {$this->jobPosting->description}"
            );

            $this->dispatch('toast', message: "Draft generated using your {$resumeSource}!", type: 'success');

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
        $this->validate([
            'content' => 'required|string',
        ]);

        $this->jobPosting->update([
            'cover_letter' => $this->content
        ]);

        $this->dispatch('toast', message: 'Cover letter saved to application.', type: 'success');
    }

    public function executeDelete()
    {
        $this->jobPosting->update(['cover_letter' => null]);
        session()->flash('success', 'Cover letter draft deleted successfully.');
        
        // Redirect back to index after deleting the content
        return redirect()->route('cover-letters.index');
    }

    public function render()
    {
        return view('livewire.cover-letter-editor');
    }
}