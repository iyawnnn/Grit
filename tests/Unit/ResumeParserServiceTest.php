<?php

namespace Tests\Unit;

use App\Services\ResumeParserService;
use Exception;
use Illuminate\Support\Facades\Log;
use Mockery;
use Smalot\PdfParser\Parser;
use Smalot\PdfParser\Document;
use Tests\TestCase;

class ResumeParserServiceTest extends TestCase
{
    public function test_parse_returns_extracted_text_from_pdf()
    {
        $documentMock = Mockery::mock(Document::class);
        $documentMock->shouldReceive('getText')->andReturn("Extracted Resume Text");

        $parserMock = Mockery::mock(Parser::class);
        $parserMock->shouldReceive('parseFile')->with('dummy_path.pdf')->andReturn($documentMock);

        $service = new ResumeParserService($parserMock);
        $result = $service->parse('dummy_path.pdf');

        $this->assertEquals("Extracted Resume Text", $result);
    }

    public function test_parse_returns_null_on_failure()
    {
        $parserMock = Mockery::mock(Parser::class);
        $parserMock->shouldReceive('parseFile')->andThrow(new Exception('Corrupted PDF file'));

        // Updated this line to match our new code ("standard parsing failed")
        Log::shouldReceive('error')
            ->once()
            ->with('Resume standard parsing failed: Corrupted PDF file');

        $service = new ResumeParserService($parserMock);
        $result = $service->parse('dummy_path.pdf');

        $this->assertNull($result);
    }

    public function test_parse_handles_utf8_encoding()
    {
        $dirtyText = "Extracted" . chr(0x92) . " Text"; 
        
        $documentMock = Mockery::mock(Document::class);
        $documentMock->shouldReceive('getText')->andReturn($dirtyText);

        $parserMock = Mockery::mock(Parser::class);
        $parserMock->shouldReceive('parseFile')->andReturn($documentMock);

        $service = new ResumeParserService($parserMock);
        $result = $service->parse('dummy_path.pdf');

        $this->assertIsString($result);
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}