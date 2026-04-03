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
        $userId = auth()->id();
        $baseQuery = JobPosting::where('user_id', $userId);

        // PERFORMANCE BOOST: Calculate all stats in one database trip
        $stats = JobPosting::where('user_id', $userId)
            ->selectRaw("
                count(*) as total_jobs,
                sum(case when status = 'interviewing' then 1 else 0 end) as interviewing_count,
                sum(case when status in ('offered', 'hired') then 1 else 0 end) as offered_count
            ")->first();

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
            ->paginate(6);

        return view('livewire.application-index', [
            'jobs' => $jobs,
            'totalJobs' => (int) ($stats->total_jobs ?? 0),
            'interviewingCount' => (int) ($stats->interviewing_count ?? 0),
            'offeredCount' => (int) ($stats->offered_count ?? 0),
            'hasAnyJobs' => ($stats->total_jobs ?? 0) > 0,
        ]);
    }
}