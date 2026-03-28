<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Services\ResumeParserService;

class ResumeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $resumes = Resume::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('resumes.index', compact('resumes'));
    }

    // We inject your ResumeParserService here
    public function store(Request $request, ResumeParserService $parser)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        // 1. Upload to Cloudinary securely
        $response = cloudinary()->uploadApi()->upload($request->file('file')->getRealPath(), [
            'folder' => 'grit_uploads'
        ]);

        // 2. Parse the PDF to extract the raw text
        $rawText = $parser->parse($request->file('file')->getRealPath());

        // 3. Save everything to the database
        Resume::create([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'file_url' => $response['secure_url'],
            'content_raw' => $rawText, // The scraped text is saved here
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