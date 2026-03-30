<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobPosting;

class ApplicationIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = ''; 
    public $jobToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    // New: Instantly clears all active filters
    public function resetFilters()
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }

    // New: Instantly changes the status of a job
    public function updateStatus($id, $newStatus)
    {
        $job = JobPosting::where('user_id', auth()->id())->findOrFail($id);
        $job->update(['status' => $newStatus]);
        
        session()->flash('success', 'Application status updated.');
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
            $job = JobPosting::where('user_id', auth()->id())->findOrFail($this->jobToDelete);
            $job->delete();
            
            $this->jobToDelete = null;
            session()->flash('success', 'Job posting deleted successfully.');
        }
    }

    public function render()
    {
        $baseQuery = JobPosting::where('user_id', auth()->id());

        $totalJobs = (clone $baseQuery)->count();
        $interviewingCount = (clone $baseQuery)->where('status', 'interviewing')->count();
        $offeredCount = (clone $baseQuery)->where('status', 'offered')->count();

        $jobs = (clone $baseQuery)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('company', 'like', '%' . $this->search . '%')
                      ->orWhere('title', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status); 
            })
            ->latest()
            ->paginate(9);

        return view('livewire.application-index', [
            'jobs' => $jobs,
            'totalJobs' => $totalJobs,
            'interviewingCount' => $interviewingCount,
            'offeredCount' => $offeredCount,
        ]);
    }
}