<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Services\MatchAnalysisService;

class CreateMatchReport extends Component
{
    public $resume_id = '';
    public $job_posting_id = '';
    public $searchJob = '';
    public $searchResume = '';

    public $preselectedJob = false;
    public $isModal = false;

    // This method automatically runs when the component is loaded.
    // If a job ID is passed (like from the Application Show page), it configures the modal layout.
    public function mount($jobPostingId = null)
    {
        if ($jobPostingId) {
            $this->job_posting_id = $jobPostingId;
            $this->preselectedJob = true;
            $this->isModal = true;
        }
    }

    public function generate(MatchAnalysisService $matchService)
    {
        $this->validate([
            'resume_id'      => 'required|exists:resumes,id',
            'job_posting_id' => 'required|exists:job_postings,id',
        ]);

        $result = $matchService->findOrCreateReport(
            (int) $this->resume_id,
            (int) $this->job_posting_id,
            (int) auth()->id()
        );

        $message = $result['is_cached']
            ? 'Loaded your previously generated report to save time.'
            : 'Match report successfully generated.';

        session()->flash('success', $message);
        
        return redirect()->route('matches.show', $result['report']);
    }

    public function render()
    {
        // Added user_id scope to prevent users from seeing other people's jobs
        $jobs = JobPosting::where('user_id', auth()->id())
            ->when($this->searchJob, function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('title', 'like', '%' . $this->searchJob . '%')
                         ->orWhere('company', 'like', '%' . $this->searchJob . '%');
                });
            })
            ->latest()
            ->get();

        $resumes = Resume::where('user_id', auth()->id())
            ->when($this->searchResume, function ($q) {
                $q->where('label', 'like', '%' . $this->searchResume . '%');
            })
            ->orderByDesc('is_primary') // Puts Primary Resume at the very top
            ->latest()
            ->get();

        return view('livewire.create-match-report', [
            'resumes' => $resumes,
            'jobs'    => $jobs,
        ]);
    }
}