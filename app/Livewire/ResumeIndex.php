<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Resume;
use App\Services\ResumeParserService;
use Livewire\Attributes\Validate;

class ResumeIndex extends Component
{
    use WithFileUploads, WithPagination;

    #[Validate('required|string|max:255')]
    public $label = '';

    #[Validate('required|file|mimes:pdf|max:5120')]
    public $file;

    public function save(ResumeParserService $parser)
    {
        $this->validate();

        $uploadResult = $parser->processUpload($this->file);

        Resume::create([
            'user_id'     => auth()->id(),
            'label'       => $this->label,
            'file_url'    => $uploadResult['file_url'],
            'content_raw' => $uploadResult['content_raw'],
            'is_active'   => true,
        ]);

        $this->reset(['label', 'file']);
        session()->flash('success', 'Resume uploaded and parsed successfully.');
    }

    public function deleteResume($id)
    {
        $resume = Resume::where('user_id', auth()->id())->findOrFail($id);

        if (preg_match('/upload\/(?:v\d+\/)?(.+)\.[a-zA-Z]+$/', $resume->file_url, $matches)) {
            $publicId = $matches[1];
            cloudinary()->uploadApi()->destroy($publicId);
        }

        $resume->delete();
        session()->flash('success', 'Resume deleted successfully.');
    }

    public function render()
    {
        $resumes = Resume::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.resume-index', [
            'resumes' => $resumes,
        ]);
    }
}