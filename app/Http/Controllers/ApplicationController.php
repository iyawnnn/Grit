<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;

class ApplicationController extends Controller
{
    public function index()
    {
        // Fetch jobs directly from the database. It is fast and prevents pagination errors.
        $jobs = JobPosting::latest()->paginate(10);

        return view('applications.index', compact('jobs'));
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
        return view('applications.show', compact('jobPosting'));
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