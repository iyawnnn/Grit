<?php

namespace App\Filament\Resources\MatchReports\Pages;

use App\Filament\Resources\MatchReports\MatchReportResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Services\MatchAnalysisService;

class CreateMatchReport extends CreateRecord
{
    protected static string $resource = MatchReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Assign the user ID to ensure ownership
        $data['user_id'] = auth()->id();

        // 2. Fetch the actual Resume and Job models using the IDs from the form
        $resume = Resume::find($data['resume_id']);
        $jobPosting = JobPosting::find($data['job_id']);

        // 3. If both exist, run the Brain BEFORE we save to the database
        if ($resume && $jobPosting) {
            $service = new MatchAnalysisService();
            $analysis = $service->analyze($resume, $jobPosting);

            // 4. Inject the calculated score and missing keywords directly into the save payload
            $data['score'] = $analysis['score'];
            $data['missing_keywords'] = $analysis['missing_keywords'];
        } else {
            // Safety fallback just in case something goes wrong
            $data['score'] = 0;
            $data['missing_keywords'] = [];
        }

        return $data;
    }

}