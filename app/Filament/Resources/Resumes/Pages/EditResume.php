<?php

namespace App\Filament\Resources\Resumes\Pages;

use App\Filament\Resources\Resumes\ResumeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditResume extends EditRecord
{
    protected static string $resource = ResumeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function afterSave(): void
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
