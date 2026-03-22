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

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $record->load(['resume', 'jobPosting']);

        if ($record->resume && $record->jobPosting) {
            $service = new \App\Services\MatchAnalysisService();
            $analysis = $service->analyze($record->resume, $record->jobPosting);

            $record->update([
                'score' => $analysis['score'],
                'missing_keywords' => $analysis['missing_keywords'],
            ]);
        }
    }
}
