<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser; // This is the new universal parser

class ResumeParserService
{
    public function parse(string $filePath): ?string
    {
        try {
            // 1. Initialize the pure PHP parser
            $parser = new Parser();
            
            // 2. Read the file directly
            $pdf = $parser->parseFile($filePath);
            
            // 3. Extract the raw text
            $rawText = $pdf->getText();

            // 4. Clean the text to prevent UTF-8 errors in the dashboard
            $cleanText = mb_convert_encoding($rawText, 'UTF-8', 'UTF-8');

            return $cleanText;

        } catch (Exception $e) {
            Log::error('Resume parsing failed: ' . $e->getMessage(), [
                'file' => $filePath,
                'exception' => $e
            ]);
            
            return null;
        }
    }
}