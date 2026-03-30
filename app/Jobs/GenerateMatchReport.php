<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Services\MatchAnalysisService;
use App\Events\MatchReportUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerateMatchReport implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(
        public MatchReport $matchReport
    ) {}

    public function handle(MatchAnalysisService $matchService): void
    {
        $resume = Resume::find($this->matchReport->resume_id);
        $jobPosting = JobPosting::find($this->matchReport->job_id);

        if (!$resume || !$jobPosting) {
            $this->updateStatus('failed', 'System Error: Missing records.');
            return;
        }

        try {
            $analysis = $matchService->analyze($resume, $jobPosting);

            $this->matchReport->update([
                'score'            => $analysis['score'] ?? 0,
                'missing_keywords' => $analysis['missing_keywords'] ?? [],
                'reasoning'        => $analysis['reasoning'] ?? 'Analysis complete.',
            ]);

            $this->updateStatus('completed');

        } catch (\Throwable $e) {
            Log::error('Match Report Generation Failed: ' . $e->getMessage());
            $this->updateStatus('failed', 'An error occurred during analysis.');
        }
    }

    private function updateStatus(string $status, string $reasoning = null): void
    {
        $data = ['status' => $status];
        
        if ($reasoning) {
            $data['reasoning'] = $reasoning;
        }

        $this->matchReport->update($data);
        
        event(new MatchReportUpdated($this->matchReport));
    }
}