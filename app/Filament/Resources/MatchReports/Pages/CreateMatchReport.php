<?php

namespace App\Filament\Resources\MatchReports\Pages;

use App\Filament\Resources\MatchReports\MatchReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMatchReport extends CreateRecord
{
    protected static string $resource = MatchReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
