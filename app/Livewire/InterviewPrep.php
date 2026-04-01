<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MockInterview;
use App\Services\GroqMockInterviewService;
use Exception;

class InterviewPrep extends Component
{
    public $resume;
    public $jobPosting;
    public array $questions = [];
    public bool $isLoading = false;

    public function mount($resume, $jobPosting)
    {
        $this->resume = $resume;
        $this->jobPosting = $jobPosting;
    }

    public function generateQuestions(GroqMockInterviewService $service)
    {
        $this->isLoading = true;

        try {
            $this->questions = $service->generateQuestions(
                $this->resume->content,
                $this->jobPosting->description
            );

            // Saves to the database so the user does not repeat API calls.
            MockInterview::create([
                'user_id' => auth()->id(),
                'job_posting_id' => $this->jobPosting->id,
                'resume_id' => $this->resume->id,
                'questions' => $this->questions,
            ]);
        } catch (Exception $e) {
            $this->addError('api', 'Failed to generate questions. Please try again.');
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.interview-prep');
    }
}