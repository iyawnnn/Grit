<?php

namespace App\Livewire;

use App\Models\JobPosting;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Cover Letters')]
class CoverLetterIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public $coverLetterToDelete = null;
    public $selectedJobForNewLetter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('search');
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->coverLetterToDelete = $id;
    }

    public function executeDelete()
    {
        if ($this->coverLetterToDelete) {
            $job = auth()->user()->jobPostings()->find($this->coverLetterToDelete);
            
            if ($job) {
                $job->update(['cover_letter' => null]);
                $this->dispatch('toast', message: 'Cover letter draft deleted successfully.', type: 'success');
            }
            
            $this->coverLetterToDelete = null;
        }
    }

    public function cancelDelete()
    {
        $this->coverLetterToDelete = null;
    }

    public function startWorkspace()
    {
        $this->validate([
            'selectedJobForNewLetter' => 'required|exists:job_postings,id'
        ]);

        return redirect()->route('cover-letters.edit', $this->selectedJobForNewLetter);
    }

    public function getCreditsRemainingProperty(): int
    {
        $dailyLimit = config('services.groq.daily_limit', 5);
        $dailyKey = 'cv-gen-daily:' . auth()->id();
        $attempts = RateLimiter::attempts($dailyKey);
        return max(0, $dailyLimit - $attempts);
    }

    public function render()
    {
        $query = auth()->user()->jobPostings()->whereNotNull('cover_letter');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('company', 'like', '%' . $this->search . '%');
            });
        }

        $jobs = $query->latest()->paginate(12);
        
        $availableJobsForCreation = auth()->user()->jobPostings()
            ->whereNull('cover_letter')
            ->latest()
            ->get();

        return view('livewire.cover-letter-index', [
            'jobs' => $jobs,
            'totalDrafts' => auth()->user()->jobPostings()->whereNotNull('cover_letter')->count(),
            'availableJobs' => $availableJobsForCreation,
            'creditsRemaining' => $this->creditsRemaining,
            'dailyLimit' => config('services.groq.daily_limit', 5),
        ]);
    }
}