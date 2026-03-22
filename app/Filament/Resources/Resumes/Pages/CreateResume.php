<?php

namespace App\Filament\Resources\Resumes\Pages;

use App\Filament\Resources\Resumes\ResumeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateResume extends CreateRecord
{
    protected static string $resource = ResumeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        
        if ($record->file_url) {
            $path = \Illuminate\Support\Facades\Storage::disk('public')->path($record->file_url);
            $service = new \App\Services\ResumeParserService();
            $text = $service->parse($path);
            
            if ($text !== null) {
                $record->update(['content_raw' => $text]);
            }
        }
    }
}
