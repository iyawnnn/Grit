<?php

namespace App\Livewire;

use App\Enums\ApplicationStatus;
use App\Models\JobPosting;
use App\Services\GroqFormatterService;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateApplication extends Component
{
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $company = '';

    #[Validate('nullable|url|max:255')]
    public $url = '';

    #[Validate('required|string')]
    public $description = '';

    public bool $isFormatting = false;

    public function autoFormatDescription(GroqFormatterService $formatter)
    {
        if (empty(trim(strip_tags($this->description)))) {
            $this->dispatch('toast', message: 'Please paste a description first before formatting.', type: 'error');
            return;
        }

        $this->isFormatting = true;

        try {
            $cleanHtml = $formatter->formatJobDescription($this->description);
            $this->description = $cleanHtml;
            
            $this->dispatch('description-formatted', html: $cleanHtml);
            $this->dispatch('toast', message: 'Description formatted successfully.', type: 'success');
            
        } catch (Exception $e) {
            Log::error('Description Formatting Error: ' . $e->getMessage());
            $this->dispatch('toast', message: 'Failed to format description.', type: 'error');
        } finally {
            $this->isFormatting = false;
        }
    }

    public function save()
    {
        $this->validate();

        JobPosting::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'company' => $this->company,
            'source_url' => $this->url,
            'description' => $this->description,
            'status' => ApplicationStatus::Saved->value,
        ]);

        session()->flash('success', 'Job posting saved successfully.');

        return redirect()->route('applications.index');
    }

    public function render()
    {
        return view('livewire.create-application');
    }
}