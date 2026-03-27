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

        // Required because the score column is not nullable
        $data['score'] = 0;

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
