<?php

namespace App\Filament\Resources\MatchReports\Pages;

use App\Filament\Resources\MatchReports\MatchReportResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Services\MatchAnalysisService;
use Illuminate\Support\Facades\Auth; 

class CreateMatchReport extends CreateRecord
{
    protected static string $resource = MatchReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Assign the user ID 
        $data['user_id'] = Auth::id();

        // 2. Fetch the actual Resume and Job models using the IDs from the form
        // Change this line to use job_id
        $resume = Resume::find($data['resume_id']);
        $jobPosting = JobPosting::find($data['job_id']); 

        // 3. If both exist, run the AI Brain BEFORE we save to the database
        if ($resume && $jobPosting) {
            $service = new MatchAnalysisService();
            $analysis = $service->analyze($resume, $jobPosting);

            // 4. Inject the calculated data directly into the save payload
            $data['score'] = $analysis['score'] ?? 0;
            $data['missing_keywords'] = $analysis['missing_keywords'] ?? [];
            $data['reasoning'] = $analysis['reasoning'] ?? 'No reasoning provided.';
        } else {
            // Safety fallback 
            $data['score'] = 0;
            $data['missing_keywords'] = [];
            $data['reasoning'] = 'System Error: Could not load Resume or Job Posting.';
        }

        return $data;
    }
}