<?php

namespace App\Livewire;

use App\Models\JobPosting;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Cover Letters')]
class CoverLetterIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public $coverLetterToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status']);
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

    public function render()
    {
        $query = auth()->user()->jobPostings();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('company', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status === 'drafted') {
            $query->whereNotNull('cover_letter');
        } elseif ($this->status === 'pending') {
            $query->whereNull('cover_letter');
        }

        $jobs = $query->latest()->paginate(12);

        return view('livewire.cover-letter-index', [
            'jobs' => $jobs,
            'totalJobs' => auth()->user()->jobPostings()->count(),
            'draftedCount' => auth()->user()->jobPostings()->whereNotNull('cover_letter')->count(),
            'pendingCount' => auth()->user()->jobPostings()->whereNull('cover_letter')->count(),
            'hasAnyJobs' => auth()->user()->jobPostings()->exists(),
        ]);
    }
}