<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MatchReport;

class MatchReportIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteReport($id)
    {
        $report = MatchReport::where('user_id', auth()->id())->findOrFail($id);
        $report->delete();

        session()->flash('success', 'Report deleted successfully.');
    }

    public function render()
    {
        // Query related models to allow searching by job title, company, or resume label
        $matches = MatchReport::with(['resume', 'jobPosting'])
            ->where('user_id', auth()->id())
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
            ->latest()
            ->paginate(10);

        return view('livewire.match-report-index', [
            'matches' => $matches
        ]);
    }
}