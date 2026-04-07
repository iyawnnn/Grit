<?php

namespace App\Livewire;

use App\Models\MatchReport;
use Livewire\Component;

class EditApplication extends Component
{
    public MatchReport $matchReport;
    public string $company_name = '';
    public string $job_title = '';
    public string $job_description = '';
    public string $status = '';
    public ?string $applied_date = null;
    public ?string $notes = '';

    public function mount(MatchReport $matchReport)
    {
        $this->matchReport = $matchReport;

        if ($this->matchReport->user_id !== auth()->id()) {
            abort(403);
        }

        
        $this->company_name = $this->matchReport->jobPosting->company_name ?? '';
        $this->job_title = $this->matchReport->jobPosting->job_title ?? '';
        $this->job_description = $this->matchReport->jobPosting->description ?? ''; 
        $this->status = $this->matchReport->status->value;
        $this->applied_date = $this->matchReport->created_at->format('Y-m-d');
        $this->notes = $this->matchReport->notes ?? '';
    }

    public function save()
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'status' => 'required|string',
            'applied_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        
        $this->matchReport->jobPosting->update([
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'description' => $this->job_description, 
        ]);

        
        $this->matchReport->update([
            'status' => $this->status,
            'created_at' => $this->applied_date,
            'notes' => $this->notes,
        ]);

        session()->flash('success', 'Application updated successfully.');
        return redirect()->route('applications.index');
    }

    public function render()
    {
        return view('livewire.edit-application')->layout('layouts.app', ['title' => 'Edit Application']);
    }
}