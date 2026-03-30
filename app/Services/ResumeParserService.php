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

            return trim(mb_convert_encoding($rawText, 'UTF-8', 'UTF-8'));
        } catch (Exception $e) {
            Log::error('Resume standard parsing failed: ' . $e->getMessage());
            return null;
        }
    }

    public function processUpload(object $file): array
    {
        // Attempt standard local parsing first
        $rawText = $this->parse($file->getRealPath());

        $uploadOptions = [
            'folder' => 'grit_uploads',
        ];

        // If local parsing returns blank text, request OCR from Cloudinary
        if (empty($rawText)) {
            $uploadOptions['ocr'] = 'adv_ocr';
        }

        $cloudinaryResponse = cloudinary()->uploadApi()->upload($file->getRealPath(), $uploadOptions);

        // Extract the OCR text from the deeply nested Cloudinary response
        if (empty($rawText) && isset($cloudinaryResponse['info']['ocr']['adv_ocr']['data'][0]['textAnnotations'][0]['description'])) {
            $rawText = $cloudinaryResponse['info']['ocr']['adv_ocr']['data'][0]['textAnnotations'][0]['description'];
        }

        return [
            'file_url'    => $cloudinaryResponse['secure_url'],
            'content_raw' => $rawText,
        ];
    }
}