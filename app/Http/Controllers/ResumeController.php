<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Services\ResumeParserService;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index()
    {
        return view('resumes.index');
    }

    public function store(Request $request, ResumeParserService $parser)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        $uploadResult = $parser->processUpload($request->file('file'));

        Resume::create([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'file_url' => $uploadResult['file_url'],
            'content_raw' => $uploadResult['content_raw'],
            'is_active' => true,
        ]);

        return redirect()->route('resumes.index')->with('success', 'Resume uploaded and parsed successfully.');
    }

    public function show(Resume $resume)
    {
        if ($resume->user_id !== auth()->id()) {
            abort(403);
        }

        return view('resumes.show', compact('resume'));
    }

    public function destroy(Resume $resume)
    {
        if ($resume->user_id !== auth()->id()) {
            abort(403);
        }

        if (preg_match('/upload\/(?:v\d+\/)?(.+)\.[a-zA-Z]+$/', $resume->file_url, $matches)) {
            $publicId = $matches[1];
            cloudinary()->uploadApi()->destroy($publicId);
        }

        $resume->delete();

        return redirect()->route('resumes.index')->with('success', 'Resume deleted successfully.');
    }
}
