<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Cache; // Add this import at the top

class ApplicationController extends Controller
{
    public function index()
    {
        // Define a unique cache key for the current user
        $cacheKey = 'user_' . auth()->id() . '_applications_page_' . request('page', 1);

        // Cache the results for 60 minutes (3600 seconds)
        $jobs = Cache::remember($cacheKey, 3600, function () {
            return JobPosting::latest()->paginate(10);
        });

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

        // Clear the cache so the new job appears immediately
        $this->clearApplicationsCache();

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

        // Clear the cache so the updated details appear immediately
        $this->clearApplicationsCache();

        return redirect()->route('applications.index')->with('success', 'Job posting updated successfully.');
    }

    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();

        // Clear the cache so the deleted job is removed from the view
        $this->clearApplicationsCache();

        return redirect()->route('applications.index')->with('success', 'Job posting deleted successfully.');
    }

    // A private helper method to clear all pagination caches for this user
    private function clearApplicationsCache()
    {
        $userId = auth()->id();

        // Laravel's basic file cache does not support tags easily.
        // A simple workaround is to clear the first few pages, 
        // or you could use Cache::flush() for a small personal app.
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget('user_' . $userId . '_applications_page_' . $i);
        }
    }
}