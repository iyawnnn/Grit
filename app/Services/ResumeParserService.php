<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

class ResumeParserService
{
    public function parse(string $filePath): ?string
    {
        try {
            $binaryPath = base_path('bin/pdftotext.exe');
            
            if (!file_exists($binaryPath)) {
                throw new Exception("Binary not found at: " . $binaryPath);
            }

            // 1. Extract the raw text from the PDF
            $rawText = (new Pdf($binaryPath))
                ->setPdf($filePath)
                ->text();

            // 2. Clean the text to prevent UTF-8 JSON encoding errors
            // This strips out invisible formatting characters that crash the dashboard
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