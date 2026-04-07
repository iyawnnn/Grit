<?php

namespace App\Livewire;

use App\Models\JobPosting;
use App\Services\GroqCoverLetterService;
use Livewire\Component;
use Exception;

class EditApplication extends Component
{
    public JobPosting $jobPosting;

    public string $title = '';
    public string $company = '';
    public ?string $url = null;
    public string $description = '';
    public string $generatedCoverLetter = '';
    public bool $isGenerating = false;

    public function mount(JobPosting $jobPosting)
    {
        if ($jobPosting->user_id !== auth()->id()) {
            abort(403);
        }

        $this->jobPosting = $jobPosting;

        $this->title = $this->jobPosting->title ?? '';
        $this->company = $this->jobPosting->company ?? '';
        $this->url = $this->jobPosting->source_url ?? '';
        $this->description = $this->jobPosting->description ?? '';
        $this->generatedCoverLetter = $this->jobPosting->cover_letter ?? '';
    }

    public function generateCoverLetter(GroqCoverLetterService $service)
    {
        $this->isGenerating = true;

        try {
            
            $primaryResume = auth()->user()->resumes()->where('is_primary', true)->first();
            
            $resumeContent = $primaryResume->content_raw ?? '';
            $jobDescription = $this->description;

            if (empty($resumeContent)) {
                throw new Exception('No primary resume found. Please upload or set a primary resume first.');
            }

            if (empty($jobDescription)) {
                throw new Exception('Job description is required to generate a cover letter.');
            }

            $this->generatedCoverLetter = $service->generate($resumeContent, $jobDescription);
            
            $this->jobPosting->update([
                'cover_letter' => $this->generatedCoverLetter
            ]);

            session()->flash('success', 'Cover letter generated successfully.');

        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        } finally {
            $this->isGenerating = false;
        }
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'description' => 'required|string',
            'generatedCoverLetter' => 'nullable|string',
        ]);

        $this->jobPosting->update([
            'title' => $this->title,
            'company' => $this->company,
            'source_url' => $this->url,
            'description' => $this->description,
            'cover_letter' => $this->generatedCoverLetter,
        ]);

        session()->flash('success', 'Job posting updated successfully.');
        
        return redirect()->route('applications.show', $this->jobPosting->id);
    }

    public function render()
    {
        return view('livewire.edit-application');
    }
}