<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Resume;
use App\Models\JobPosting;
use App\Models\User;
use App\Services\MatchAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MatchAnalysisServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_analyze_returns_parsed_groq_response(): void
    {
        Cache::flush();

        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id, 'content_raw' => 'PHP Laravel MySQL Git']);
        $jobPosting = JobPosting::factory()->create(['user_id' => $user->id, 'description' => 'Looking for PHP Laravel developer with Docker']);

        $groqResponseContent = json_encode([
            'extracted_requirements' => ['PHP', 'Laravel', 'Docker'],
            'missing_keywords'       => ['Docker'],
            'score'                  => 90,
            'reasoning'              => 'The candidate matches 90 percent of the requirements. Docker experience is missing from the resume.',
        ]);

        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => $groqResponseContent,
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = new MatchAnalysisService();
        $result = $service->analyze($resume, $jobPosting);

        $this->assertIsArray($result);
        $this->assertEquals(90, $result['score']);
        $this->assertContains('Docker', $result['missing_keywords']);
        $this->assertStringContainsString('90 percent', $result['reasoning']);
    }

    public function test_analyze_falls_back_to_offline_on_api_failure(): void
    {
        Cache::flush();

        $user = User::factory()->create();
        $resume = Resume::factory()->create([
            'user_id'     => $user->id,
            'content_raw' => 'experienced software developer with python django testing deployment',
        ]);
        $jobPosting = JobPosting::factory()->create([
            'user_id'     => $user->id,
            'description' => 'We need a software developer experienced with python django kubernetes',
        ]);

        Http::fake([
            'api.groq.com/*' => Http::response('Internal Server Error', 500),
        ]);

        $service = new MatchAnalysisService();
        $result = $service->analyze($resume, $jobPosting);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('score', $result);
        $this->assertArrayHasKey('missing_keywords', $result);
        $this->assertContains('(Offline Backup)', $result['missing_keywords']);
        $this->assertGreaterThanOrEqual(0, $result['score']);
    }

    public function test_analyze_caches_results(): void
    {
        Cache::flush();

        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);
        $jobPosting = JobPosting::factory()->create(['user_id' => $user->id]);

        $groqResponseContent = json_encode([
            'extracted_requirements' => ['PHP'],
            'missing_keywords'       => [],
            'score'                  => 100,
            'reasoning'              => 'Perfect match.',
        ]);

        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => $groqResponseContent]],
                ],
            ], 200),
        ]);

        $service = new MatchAnalysisService();

        $firstResult = $service->analyze($resume, $jobPosting);
        $secondResult = $service->analyze($resume, $jobPosting);

        $this->assertEquals($firstResult, $secondResult);

        Http::assertSentCount(1);
    }
}
