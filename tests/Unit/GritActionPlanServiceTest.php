<?php

namespace Tests\Unit;

use App\Models\MatchReport;
use App\Services\GritActionPlanService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GritActionPlanServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_success_message_when_no_keywords_missing(): void
    {
        $service = new GritActionPlanService();
        $report = MatchReport::factory()->create([
            'missing_keywords' => []
        ]);

        $result = $service->generatePlan($report);
        $decoded = json_decode($result, true);

        $this->assertEquals('Great Job!', $decoded['steps'][0]['title']);
    }

    public function test_it_generates_plan_and_updates_report_on_success(): void
    {
        // Mock the external Groq API response
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => '{"steps": [{"title": "Step 1", "actions": ["Learn PHP"]}]}'
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new GritActionPlanService();
        $report = MatchReport::factory()->create([
            'missing_keywords' => ['PHP', 'Laravel']
        ]);

        $result = $service->generatePlan($report);

        $this->assertStringContainsString('Learn PHP', $result);
        $this->assertNotNull($report->fresh()->action_plan);
    }

    public function test_it_throws_exception_on_api_failure(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([], 500)
        ]);

        $service = new GritActionPlanService();
        $report = MatchReport::factory()->create([
            'missing_keywords' => ['React']
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to generate action plan from Groq API.');

        $service->generatePlan($report);
    }
}