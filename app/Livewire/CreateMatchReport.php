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
            ? 'We loaded your previously generated report to save time.'
            : 'Your match report has been successfully generated.';

        return redirect()->route('matches.show', $result['report'])->with('success', $message);
    }

    public function render()
    {
        return view('livewire.create-match-report', [
            'resumes' => Resume::where('user_id', auth()->id())->get(),
            'jobs'    => JobPosting::latest()->get(),
        ]);
    }
}