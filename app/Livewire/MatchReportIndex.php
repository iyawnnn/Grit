<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MatchReport;
use Livewire\Attributes\Url;

class MatchReportIndex extends Component
{
    use WithPagination;

    // We use the #[Url] attribute so these stay in the address bar when refreshed
    #[Url]
    public $search = '';
    
    #[Url]
    public $sort = 'newest';
    
    public $reportToDelete = null;
    
    // This variable controls if the modal is open
    public $showCreateModal = false;

    public function mount()
    {
        // If the URL has ?action=create, we open the modal automatically
        if (request()->query('action') === 'create') {
            $this->showCreateModal = true;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->reportToDelete = $id;
    }

    public function executeDelete()
    {
        if ($this->reportToDelete) {
            $report = MatchReport::where('user_id', auth()->id())->findOrFail($this->reportToDelete);
            $report->delete();
            
            $this->reportToDelete = null;
            
            session()->flash('success', 'Match report deleted successfully.');
            $this->dispatch('notify', message: 'Match report deleted successfully.');
        }
    }

    public function cancelDelete()
    {
        $this->reportToDelete = null;
    }

    public function render()
    {
        $userId = auth()->id();

        $totalReports = MatchReport::where('user_id', $userId)->count();
        $processingCount = MatchReport::where('user_id', $userId)->where('status', 'processing')->count();
        $highestScore = MatchReport::where('user_id', $userId)->where('status', '!=', 'processing')->max('score') ?? 0;

        $matches = MatchReport::with(['resume', 'jobPosting'])
            ->where('user_id', $userId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('jobPosting', function ($subQuery) {
                        $subQuery->where('title', 'like', '%' . $this->search . '%')
                                 ->orWhere('company', 'like', '%' . $this->search . '%');
                    })->orWhereHas('resume', function ($subQuery) {
                        $subQuery->where('label', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->sort === 'newest', fn($q) => $q->latest())
            ->when($this->sort === 'oldest', fn($q) => $q->oldest())
            ->when($this->sort === 'score_high', fn($q) => $q->orderByDesc('score'))
            ->when($this->sort === 'score_low', fn($q) => $q->orderBy('score'))
            ->paginate(9);

        return view('livewire.match-report-index', [
            'matches' => $matches,
            'totalReports' => $totalReports,
            'processingCount' => $processingCount,
            'highestScore' => $highestScore,
        ]);
    }
}