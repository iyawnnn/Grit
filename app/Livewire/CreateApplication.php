<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\JobPosting;

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

    public function save()
    {
        $this->validate();

        JobPosting::create([
            'user_id' => auth()->id(), // Binds the job to the logged-in user
            'title' => $this->title,
            'company' => $this->company,
            'source_url' => $this->url, // Changed to match your database column
            'description' => $this->description,
        ]);

        return redirect()->route('applications.index')->with('success', 'Job posting saved successfully.');
    }

    public function render()
    {
        return view('livewire.create-application');
    }
}