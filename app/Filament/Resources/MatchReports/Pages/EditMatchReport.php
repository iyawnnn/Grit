<?php

namespace App\Filament\Resources\MatchReports\Pages;

use App\Filament\Resources\MatchReports\MatchReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMatchReport extends EditRecord
{
    protected static string $resource = MatchReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
