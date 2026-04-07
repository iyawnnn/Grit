<?php

namespace App\Livewire;

namespace App\Livewire;

use App\Models\MockInterview;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Interview Prep')]
class InterviewIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $sort = 'newest';

    public $interviewToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->interviewToDelete = $id;
    }

    public function executeDelete()
    {
        if ($this->interviewToDelete) {
            MockInterview::where('id', $this->interviewToDelete)->where('user_id', auth()->id())->delete();
            $this->interviewToDelete = null;
        }
    }

    public function cancelDelete()
    {
        $this->interviewToDelete = null;
    }

    public function render()
    {
        $query = MockInterview::where('user_id', auth()->id())->with(['jobPosting', 'resume']);

        if ($this->search) {
            $query->whereHas('jobPosting', function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('company', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->sort === 'newest') {
            $query->latest();
        } elseif ($this->sort === 'oldest') {
            $query->oldest();
        }

        return view('livewire.interview-index', [
            'interviews' => $query->paginate(9),
            'totalInterviews' => MockInterview::where('user_id', auth()->id())->count(),
            'latestInterview' => MockInterview::where('user_id', auth()->id())->latest()->first(),
        ]);
    }
}
