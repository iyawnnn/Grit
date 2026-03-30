<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\ResumeParserService;
use Illuminate\Support\Facades\Log;
use Mockery;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Parser;
use Tests\TestCase;

class ResumeParserServiceTest extends TestCase
{
    public function test_parse_returns_extracted_text_from_pdf(): void
    {
        $expectedText = "Ian Macabulos\nSoftware Engineer\nPHP, Laravel, JavaScript, React";

        $mockDocument = Mockery::mock(Document::class);
        $mockDocument->shouldReceive('getText')
            ->once()
            ->andReturn($expectedText);

        $mockParser = Mockery::mock(Parser::class);
        $mockParser->shouldReceive('parseFile')
            ->with('/fake/path/resume.pdf')
            ->once()
            ->andReturn($mockDocument);

        $service = new ResumeParserService($mockParser);
        $result = $service->parse('/fake/path/resume.pdf');

        $this->assertNotNull($result);
        $this->assertStringContainsString('Laravel', $result);
        $this->assertStringContainsString('Ian Macabulos', $result);
    }

    public function test_parse_returns_null_on_failure(): void
    {
        Log::shouldReceive('error')
            ->once()
            ->withArgs(function (string $message) {
                return str_contains($message, 'Resume parsing failed');
            });

        $mockParser = Mockery::mock(Parser::class);
        $mockParser->shouldReceive('parseFile')
            ->with('/fake/path/corrupt.pdf')
            ->once()
            ->andThrow(new \Exception('Corrupted PDF file'));

        $service = new ResumeParserService($mockParser);
        $result = $service->parse('/fake/path/corrupt.pdf');

        $this->assertNull($result);
    }

    public function test_parse_handles_utf8_encoding(): void
    {
        $textWithSpecialChars = "José García\nDéveloppeur\nExpérience en création d'applications";

        $mockDocument = Mockery::mock(Document::class);
        $mockDocument->shouldReceive('getText')
            ->once()
            ->andReturn($textWithSpecialChars);

        $mockParser = Mockery::mock(Parser::class);
        $mockParser->shouldReceive('parseFile')
            ->once()
            ->andReturn($mockDocument);

        $service = new ResumeParserService($mockParser);
        $result = $service->parse('/fake/path/international.pdf');

        $this->assertNotNull($result);
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
        $this->assertStringContainsString('José', $result);
    }
}
