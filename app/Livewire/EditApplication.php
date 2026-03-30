<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\JobPosting;

class EditApplication extends Component
{
    public JobPosting $jobPosting;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $company = '';

    #[Validate('nullable|url|max:255')]
    public $url = '';

    #[Validate('required|string')]
    public $description = '';

    public function mount(JobPosting $jobPosting)
    {
        $this->jobPosting = $jobPosting;
        $this->title = $jobPosting->title;
        $this->company = $jobPosting->company;
        $this->url = $jobPosting->source_url;
        $this->description = $jobPosting->description;
    }

    public function update()
    {
        $this->validate();

        $this->jobPosting->update([
            'title' => $this->title,
            'company' => $this->company,
            'source_url' => $this->url,
            'description' => $this->description,
        ]);

        return redirect()->route('applications.index')->with('success', 'Job posting updated successfully.');
    }

    public function render()
    {
        return view('livewire.edit-application');
    }
}