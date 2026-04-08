<?php

namespace App\Livewire;

use App\Models\JobPosting;
use App\Services\GroqCoverLetterService;
use Livewire\Component;
use Exception;

class CoverLetterGenerator extends Component
{
    public $jobs;
    public $jobId = '';
    public ?JobPosting $selectedJob = null;
    public string $coverLetterContent = '';
    public bool $isGenerating = false;

    public function mount()
    {
        $this->jobs = auth()->user()->jobPostings()->latest()->get();

        if (request()->has('job_id')) {
            $this->jobId = request('job_id');
            $this->loadJob();
        }
    }

    public function updatedJobId()
    {
        $this->loadJob();
    }

    public function loadJob()
    {
        if (empty($this->jobId)) {
            $this->selectedJob = null;
            $this->coverLetterContent = '';
            return;
        }

        $this->selectedJob = auth()->user()->jobPostings()->find($this->jobId);
        $this->coverLetterContent = $this->selectedJob->cover_letter ?? '';
    }

    public function generate(GroqCoverLetterService $service)
    {
        if (!$this->selectedJob) {
            session()->flash('error', 'Please select an application first.');
            return;
        }

        $this->isGenerating = true;

        try {
            $primaryResume = auth()->user()->resumes()->where('is_primary', true)->first();

            if (!$primaryResume || empty($primaryResume->content_raw)) {
                throw new Exception('Please upload and set a primary resume in your profile first.');
            }

            // Generate draft and populate the editor
            $this->coverLetterContent = $service->generate(
                $primaryResume->content_raw,
                "Company: {$this->selectedJob->company}\nJob Title: {$this->selectedJob->title}\nDescription: {$this->selectedJob->description}"
            );

            session()->flash('success', 'Draft generated successfully! You can now edit and save it.');

        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        } finally {
            $this->isGenerating = false;
        }
    }

    public function save()
    {
        if (!$this->selectedJob) return;

        $this->validate([
            'coverLetterContent' => 'required|string',
        ]);

        $this->selectedJob->update([
            'cover_letter' => $this->coverLetterContent
        ]);

        session()->flash('success', 'Cover letter saved to application successfully.');
    }

    public function render()
    {
        return view('livewire.cover-letter-generator');
    }
}