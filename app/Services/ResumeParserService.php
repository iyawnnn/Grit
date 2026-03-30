<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class ResumeParserService
{
    protected ?Parser $parser;

    public function __construct(?Parser $parser = null)
    {
        $this->parser = $parser;
    }

    public function parse(string $filePath): ?string
    {
        try {
            $pdfParser = $this->parser ?? new Parser();
            $pdf = $pdfParser->parseFile($filePath);
            $rawText = $pdf->getText();

            return mb_convert_encoding($rawText, 'UTF-8', 'UTF-8');
        } catch (Exception $e) {
            Log::error('Resume parsing failed: ' . $e->getMessage(), [
                'file' => $filePath,
                'exception' => $e,
            ]);

            return null;
        }
    }

    public function processUpload(object $file): array
    {
        $cloudinaryResponse = cloudinary()->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'grit_uploads',
        ]);

        $rawText = $this->parse($file->getRealPath());

        return [
            'file_url'    => $cloudinaryResponse['secure_url'],
            'content_raw' => $rawText,
        ];
    }
}