<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MatchReport;
use App\Models\MockInterview;
use App\Services\GroqMockInterviewService;
use Exception;

class InterviewPrep extends Component
{
    public MatchReport $matchReport;
    public array $questions = [];

    public function mount(MatchReport $matchReport)
    {
        $this->matchReport = $matchReport;
        
        if ($this->matchReport->user_id !== auth()->id()) {
            abort(403);
        }

        // Properly check using the relation IDs instead of direct column names
        $existingInterview = MockInterview::where('user_id', auth()->id())
            ->where('resume_id', $this->matchReport->resume->id)
            ->where('job_posting_id', $this->matchReport->jobPosting->id)
            ->first();

        if ($existingInterview) {
            $this->questions = $existingInterview->questions;
        }
    }

    public function generateQuestions(GroqMockInterviewService $service)
    {
        try {
            $resumeText = $this->matchReport->resume->content_raw ?? 'No resume content available.';
            $jobText = $this->matchReport->jobPosting->description ?? 'No job description available.';

            $this->questions = $service->generateQuestions($resumeText, $jobText);

            // Properly save using the relation IDs
            MockInterview::create([
                'user_id' => auth()->id(),
                'job_posting_id' => $this->matchReport->jobPosting->id,
                'resume_id' => $this->matchReport->resume->id,
                'questions' => $this->questions,
            ]);
        } catch (Exception $e) {
            $this->addError('api', 'Failed to generate questions. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.interview-prep')->layout('layouts.app', ['title' => 'Interview Prep']);
    }
}