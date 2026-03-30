<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobPosting;
use Livewire\Attributes\Url;

class ApplicationIndex extends Component
{
    use WithPagination;

    // The #[Url] attribute keeps your search and filter in the browser URL
    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $status = '';

    public $jobToDelete = null;

    // This forces the page to reset to 1 when you type in the search bar
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // This forces the page to reset to 1 when you change the filter
    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }

    public function updateStatus($id, $newStatus)
    {
        $job = JobPosting::where('user_id', auth()->id())->find($id);

        if ($job) {
            $job->update(['status' => $newStatus]);
            $this->dispatch('notify', message: 'Status updated to ' . ucfirst($newStatus) . '.');
        }
    }

    public function confirmDelete($id)
    {
        $this->jobToDelete = $id;
    }

    public function cancelDelete()
    {
        $this->jobToDelete = null;
    }

    public function executeDelete()
    {
        if ($this->jobToDelete) {
            $job = JobPosting::where('user_id', auth()->id())->find($this->jobToDelete);

            if ($job) {
                $job->delete();
            }

            $this->jobToDelete = null;
            $this->dispatch('notify', message: 'Role permanently removed.');
        }
    }

    public function render()
    {
        $baseQuery = JobPosting::where('user_id', auth()->id());

        // Check if the user has ANY jobs in the database, ignoring current search filters
        $hasAnyJobs = (clone $baseQuery)->exists();

        $totalJobs = (clone $baseQuery)->count();
        $interviewingCount = (clone $baseQuery)->where('status', 'interviewing')->count();
        $offeredCount = (clone $baseQuery)->whereIn('status', ['offered', 'hired'])->count();

        $jobs = (clone $baseQuery)
            ->when($this->search, function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('company', 'like', $searchTerm)
                        ->orWhere('title', 'like', $searchTerm);
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            // Updated pagination to 6 per page
            ->paginate(6);

        return view('livewire.application-index', [
            'jobs' => $jobs,
            'totalJobs' => $totalJobs,
            'interviewingCount' => $interviewingCount,
            'offeredCount' => $offeredCount,
            'hasAnyJobs' => $hasAnyJobs,
        ]);
    }
}