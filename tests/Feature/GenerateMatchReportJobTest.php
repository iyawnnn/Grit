<?php

namespace Tests\Feature;

use App\Jobs\GenerateMatchReport;
use App\Models\JobPosting;
use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\User;
use App\Services\MatchAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class GenerateMatchReportJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_report_status_to_completed_on_success()
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);
        $jobPosting = JobPosting::factory()->create(['user_id' => $user->id]);

        $report = MatchReport::create([
            'user_id' => $user->id,
            'resume_id' => $resume->id,
            'job_id' => $jobPosting->id,
            'status' => 'pending',
            'score' => 0,
            'reasoning' => null,
        ]);

        $this->mock(MatchAnalysisService::class, function (MockInterface $mock) {
            $mock->shouldReceive('analyze')
                ->once()
                ->andReturn([
                    'score' => 95,
                    'missing_keywords' => ['Laravel', 'Vue'],
                    'reasoning' => 'This is a mocked AI response.'
                ]);
        });

        $job = new GenerateMatchReport($report);
        $job->handle(app(MatchAnalysisService::class));

        $this->assertDatabaseHas('match_reports', [
            'id' => $report->id,
            'status' => 'completed',
            'score' => 95,
        ]);
    }

    public function test_it_handles_api_failure_gracefully()
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);
        $jobPosting = JobPosting::factory()->create(['user_id' => $user->id]);

        $report = MatchReport::create([
            'user_id' => $user->id,
            'resume_id' => $resume->id,
            'job_id' => $jobPosting->id,
            'status' => 'pending',
            'score' => 0,
            'reasoning' => null,
        ]);

        $this->mock(MatchAnalysisService::class, function (MockInterface $mock) {
            $mock->shouldReceive('analyze')
                ->once()
                ->andThrow(new \Exception('Groq API connection failed'));
        });

        $job = new GenerateMatchReport($report);
        $job->handle(app(MatchAnalysisService::class));

        $this->assertDatabaseHas('match_reports', [
            'id' => $report->id,
            'status' => 'failed',
        ]);
    }
}