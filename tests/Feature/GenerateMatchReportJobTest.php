<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\GenerateMatchReport;
use App\Models\JobPosting;
use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\User;
use App\Services\MatchAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateMatchReportJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_updates_report_status_to_completed(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);
        $jobPosting = JobPosting::factory()->create(['user_id' => $user->id]);

        $matchReport = MatchReport::factory()->create([
            'user_id'   => $user->id,
            'resume_id' => $resume->id,
            'job_id'    => $jobPosting->id,
            'score'     => 0,
            'status'    => 'processing',
        ]);

        $mockService = $this->mock(MatchAnalysisService::class);
        $mockService->shouldReceive('analyze')
            ->once()
            ->with(
                \Mockery::on(fn ($r) => $r->id === $resume->id),
                \Mockery::on(fn ($j) => $j->id === $jobPosting->id)
            )
            ->andReturn([
                'score'            => 85,
                'missing_keywords' => ['Kubernetes'],
                'reasoning'        => 'Strong match with minor gaps in container orchestration.',
            ]);

        $job = new GenerateMatchReport($matchReport);
        $job->handle($mockService);

        $matchReport->refresh();

        $this->assertEquals('completed', $matchReport->status);
        $this->assertEquals(85, $matchReport->score);
        $this->assertContains('Kubernetes', $matchReport->missing_keywords);
        $this->assertStringContainsString('container orchestration', $matchReport->reasoning);
    }

    public function test_job_sets_status_to_failed_when_resume_not_found(): void
    {
        $user = User::factory()->create();
        $jobPosting = JobPosting::factory()->create(['user_id' => $user->id]);
        $resume = Resume::factory()->create(['user_id' => $user->id]);

        $matchReport = MatchReport::factory()->create([
            'user_id'   => $user->id,
            'resume_id' => $resume->id,
            'job_id'    => $jobPosting->id,
            'status'    => 'processing',
        ]);

        $matchReport->resume_id = 99999;

        $mockService = $this->mock(MatchAnalysisService::class);
        $mockService->shouldNotReceive('analyze');

        $job = new GenerateMatchReport($matchReport);
        $job->handle($mockService);

        $this->assertDatabaseHas('match_reports', [
            'id'     => $matchReport->id,
            'status' => 'failed',
        ]);
    }

    public function test_job_sets_status_to_failed_when_job_posting_not_found(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);
        $jobPosting = JobPosting::factory()->create(['user_id' => $user->id]);

        $matchReport = MatchReport::factory()->create([
            'user_id'   => $user->id,
            'resume_id' => $resume->id,
            'job_id'    => $jobPosting->id,
            'status'    => 'processing',
        ]);

        $matchReport->job_id = 99999;

        $mockService = $this->mock(MatchAnalysisService::class);
        $mockService->shouldNotReceive('analyze');

        $job = new GenerateMatchReport($matchReport);
        $job->handle($mockService);

        $this->assertDatabaseHas('match_reports', [
            'id'     => $matchReport->id,
            'status' => 'failed',
        ]);
    }
}
