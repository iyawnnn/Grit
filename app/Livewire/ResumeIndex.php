<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Resume;
use App\Services\ResumeParserService;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ResumeIndex extends Component
{
    use WithFileUploads, WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $sort = 'newest';

    #[Validate('required|string|max:255')]
    public $label = '';

    #[Validate('required|file|mimes:pdf|max:5120')]
    public $file;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    public function save(ResumeParserService $parser)
    {
        $this->validate();

        $uploadResult = $parser->processUpload($this->file);

        Resume::create([
            'user_id' => auth()->id(),
            'label' => $this->label,
            'file_url' => $uploadResult['file_url'],
            'content_raw' => $uploadResult['content_raw'],
            'is_primary' => false,
        ]);

        $this->reset(['label', 'file']);

        $this->dispatch('close-slide-over');
        $this->dispatch('notify', message: 'Resume uploaded and parsed successfully.');
    }

    public function togglePrimary($id)
    {
        $resume = Resume::where('user_id', auth()->id())->find($id);

        if ($resume) {
            $wasPrimary = $resume->is_primary;

            Resume::where('user_id', auth()->id())->update(['is_primary' => false]);

            if (! $wasPrimary) {
                $resume->update(['is_primary' => true]);
                $this->dispatch('notify', message: 'Primary resume set.');
            } else {
                $this->dispatch('notify', message: 'Primary status removed.');
            }
        }
    }

    public $resumeToDeleteId = null;

    public function confirmDelete($id)
    {
        $this->resumeToDeleteId = $id;
    }

    public function executeDelete()
    {
        if (!$this->resumeToDeleteId) {
            return;
        }

        $resume = Resume::where('user_id', auth()->id())->find($this->resumeToDeleteId);

        if ($resume) {
            if (preg_match('/upload\/(?:v\d+\/)?(.+)\.[a-zA-Z]+$/', $resume->file_url, $matches)) {
                $publicId = $matches[1];
                cloudinary()->uploadApi()->destroy($publicId);
            }
            $resume->delete();
            $this->dispatch('notify', message: 'Resume permanently removed.');
        }

        $this->resumeToDeleteId = null;
    }

    public function render()
    {
        $baseQuery = Resume::where('user_id', auth()->id());
        $hasAnyResumes = (clone $baseQuery)->exists();

        $totalResumes = (clone $baseQuery)->count();
        $primaryResume = (clone $baseQuery)->where('is_primary', true)->first();
        $latestResume = (clone $baseQuery)->latest()->first();

        $resumes = (clone $baseQuery)
            ->when($this->search, function ($query) {
                $searchTerm = '%'.trim($this->search).'%';
                $query->where('label', 'like', $searchTerm);
            })
            ->when($this->sort === 'newest', fn ($q) => $q->latest())
            ->when($this->sort === 'oldest', fn ($q) => $q->oldest())
            ->when($this->sort === 'name', fn ($q) => $q->orderBy('label', 'asc'))
            ->paginate(6);

        return view('livewire.resume-index', [
            'resumes' => $resumes,
            'hasAnyResumes' => $hasAnyResumes,
            'totalResumes' => $totalResumes,
            'primaryResume' => $primaryResume,
            'latestResume' => $latestResume,
        ]);
    }

    
}
