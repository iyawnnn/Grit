<?php

namespace App\Livewire;

use App\Enums\ApplicationStatus;
use App\Models\JobPosting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Application Board')]
class ApplicationBoard extends Component
{
    public $search = '';

    public function updateStatus($id, $newStatus)
    {
        $job = JobPosting::where('user_id', auth()->id())->find($id);

        if ($job) {
            $validStatuses = array_column(ApplicationStatus::cases(), 'value');

            if (in_array($newStatus, $validStatuses)) {
                $job->update(['status' => $newStatus]);

                $statusEnum = ApplicationStatus::tryFrom($newStatus);
                $this->dispatch('notify', message: "Moved to {$statusEnum->getLabel()}");
            }
        }
    }

    public function render()
    {
        // PERFORMANCE BOOST: Only select the 5 columns needed for the board
        $jobs = JobPosting::select('id', 'title', 'company', 'status', 'updated_at')
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $searchTerm = '%'.trim($this->search).'%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('company', 'like', $searchTerm)
                        ->orWhere('title', 'like', $searchTerm);
                });
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('livewire.application-board', [
            'jobs' => $jobs,
            'statuses' => ApplicationStatus::cases(),
        ]);
    }
}
