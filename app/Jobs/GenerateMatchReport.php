<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Services\MatchAnalysisService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateMatchReport implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MatchReport $matchReport
    ) {
    }

    public function handle(MatchAnalysisService $matchService): void
    {
        $resume = Resume::find($this->matchReport->resume_id);
        $jobPosting = JobPosting::find($this->matchReport->job_id);

        if (!$resume || !$jobPosting) {
            $this->matchReport->update(['status' => 'failed']);
            return;
        }

        $analysis = $matchService->analyze($resume, $jobPosting);

        $this->matchReport->update([
            'score'            => $analysis['score'] ?? 0,
            'missing_keywords' => $analysis['missing_keywords'] ?? [],
            'reasoning'        => $analysis['reasoning'] ?? 'System Error: No reasoning provided by AI.',
            'status'           => 'completed',
        ]);
    }
}