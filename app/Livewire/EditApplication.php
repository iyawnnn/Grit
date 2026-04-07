<?php

namespace App\Livewire;

use App\Models\JobPosting;
use Livewire\Component;

class EditApplication extends Component
{
    public JobPosting $jobPosting;

    public string $title = '';
    public string $company = '';
    public ?string $url = null;
    public string $description = '';

    public function mount(JobPosting $jobPosting)
    {
        if ($jobPosting->user_id !== auth()->id()) {
            abort(403);
        }

        $this->jobPosting = $jobPosting;

        $this->title = $this->jobPosting->title ?? '';
        $this->company = $this->jobPosting->company ?? '';
        $this->url = $this->jobPosting->source_url ?? '';
        $this->description = $this->jobPosting->description ?? '';
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'description' => 'required|string',
        ]);

        $this->jobPosting->update([
            'title' => $this->title,
            'company' => $this->company,
            'source_url' => $this->url,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Job posting updated successfully.');
        
        return redirect()->route('applications.show', $this->jobPosting->id);
    }

    public function render()
    {
        return view('livewire.edit-application');
    }
}