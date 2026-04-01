<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;

class ApplicationController extends Controller
{
    public function index()
    {
        // Data is now handled by the Livewire component
        return view('applications.index');
    }

    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'description' => 'required|string',
        ]);

        JobPosting::create([
            'title' => $request->title,
            'company' => $request->company,
            'url' => $request->url,
            'description' => $request->description,
        ]);

        return redirect()->route('applications.index')->with('success', 'Job posting saved successfully.');
    }

    public function show(JobPosting $jobPosting)
    {
        // FIX: Pass the $jobPosting model to the view as 'application'
        return view('applications.show', [
            'application' => $jobPosting
        ]);
    }

    public function edit(JobPosting $jobPosting)
    {
        return view('applications.edit', compact('jobPosting'));
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'description' => 'required|string',
        ]);

        $jobPosting->update([
            'title' => $request->title,
            'company' => $request->company,
            'url' => $request->url,
            'description' => $request->description,
        ]);

        return redirect()->route('applications.index')->with('success', 'Job posting updated successfully.');
    }

    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();

        return redirect()->route('applications.index')->with('success', 'Job posting deleted successfully.');
    }
}