<?php

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

        // 1. Upload to Cloudinary securely using Livewire's temporary file path
        $response = cloudinary()->uploadApi()->upload($this->file->getRealPath(), [
            'folder' => 'grit_uploads'
        ]);

        // 2. Parse the PDF to extract the raw text
        $rawText = $parser->parse($this->file->getRealPath());

        // 3. Save everything to the database
        Resume::create([
            'user_id' => auth()->id(),
            'label' => $this->label,
            'file_url' => $response['secure_url'],
            'content_raw' => $rawText,
            'is_active' => true,
        ]);

        // 4. Reset the form and show success message
        $this->reset(['label', 'file']);
        session()->flash('success', 'Resume uploaded and parsed successfully.');
    }

    public function deleteResume($id)
    {
        $resume = Resume::where('user_id', auth()->id())->findOrFail($id);

        // Delete from Cloudinary
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
            'resumes' => $resumes
        ]);
    }
}