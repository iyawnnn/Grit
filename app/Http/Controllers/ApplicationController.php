<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;

class ApplicationController extends Controller
{
    public function index()
    {
        // For now, we fetch all latest job postings
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
}