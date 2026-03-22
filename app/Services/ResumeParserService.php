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

            return (new Pdf($binaryPath))
                ->setPdf($filePath)
                ->text();
        } catch (Exception $e) {
            Log::error('Resume parsing failed: ' . $e->getMessage(), [
                'file' => $filePath,
                'exception' => $e
            ]);
            
            return null;
        }
    }
}
