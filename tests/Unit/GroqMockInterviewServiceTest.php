<?php

namespace Tests\Unit;

use App\Services\GroqMockInterviewService;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GroqMockInterviewServiceTest extends TestCase
{
    public function test_it_throws_exception_if_api_key_is_missing(): void
    {
        Config::set('services.groq.api_key', null);

        $service = new GroqMockInterviewService();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Groq API key is missing. Please check your .env file.');

        $service->generateQuestions('resume text', 'job text');
    }

    public function test_it_returns_questions_on_successful_api_call(): void
    {
        Config::set('services.groq.api_key', 'test-fake-key');

        // Mock a successful API response returning valid JSON
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => '{"questions": ["What is PHP?", "How does Laravel work?"]}'
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new GroqMockInterviewService();
        $questions = $service->generateQuestions('Sample Resume Data', 'Sample Job Data');

        $this->assertCount(2, $questions);
        $this->assertEquals('What is PHP?', $questions[0]);
    }

    public function test_it_throws_exception_on_api_failure(): void
    {
        Config::set('services.groq.api_key', 'test-fake-key');

        Http::fake([
            'api.groq.com/*' => Http::response([], 500)
        ]);

        $service = new GroqMockInterviewService();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Groq API Error: 500');

        $service->generateQuestions('Sample Resume Data', 'Sample Job Data');
    }
}