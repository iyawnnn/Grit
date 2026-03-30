<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Jobs\GenerateMatchReport;
use Illuminate\Support\Facades\Cache;

class CreateMatchReport extends Component
{
    public $resume_id = '';
    public $job_posting_id = '';

    public function generate()
    {
        $this->validate([
            'resume_id' => 'required|exists:resumes,id',
            'job_posting_id' => 'required|exists:job_postings,id',
        ]);

        $resume = Resume::where('user_id', auth()->id())->findOrFail($this->resume_id);
        $jobPosting = JobPosting::findOrFail($this->job_posting_id);

        $contentToHash = $resume->content_raw . $jobPosting->description;
        $fingerprint = hash('sha256', $contentToHash);
        $cacheKey = 'match_report_hash_' . $fingerprint;

        if (Cache::has($cacheKey)) {
            $existingReportId = Cache::get($cacheKey);
            $existingReport = MatchReport::find($existingReportId);

            if ($existingReport) {
                return redirect()->route('matches.show', $existingReport)
                    ->with('success', 'We loaded your previously generated report to save time.');
            }
        }

        $matchReport = MatchReport::create([
            'user_id' => auth()->id(),
            'resume_id' => $resume->id,
            'job_id' => $jobPosting->id,
            'score' => 0, // Added default score to satisfy database constraints
            'status' => 'processing',
        ]);

        Cache::put($cacheKey, $matchReport->id, now()->addDays(30));

        GenerateMatchReport::dispatchSync($matchReport);

        return redirect()->route('matches.show', $matchReport)
            ->with('success', 'Your match report has been successfully generated.');
    }

    public function render()
    {
        return view('livewire.create-match-report', [
            'resumes' => Resume::where('user_id', auth()->id())->get(),
            'jobs' => JobPosting::latest()->get()
        ]);
    }
}