<?php

namespace App\Filament\Resources\MatchReports\Pages;

use App\Filament\Resources\MatchReports\MatchReportResource;
use Filament\Resources\Pages\CreateRecord;
use App\Jobs\GenerateMatchReport;
use Illuminate\Support\Facades\Auth;

class CreateMatchReport extends CreateRecord
{
    protected static string $resource = MatchReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        // Set temporary values while the background job processes
        $data['score'] = 0;
        $data['missing_keywords'] = [];
        $data['reasoning'] = 'AI is currently analyzing this match. This usually takes about 10 to 15 seconds.';

        return $data;
    }

    protected function afterCreate(): void
    {
        // Dispatch the background job and pass the newly created record to it
        GenerateMatchReport::dispatch($this->record);
    }

    // Add this method to change where the user goes after clicking save
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
