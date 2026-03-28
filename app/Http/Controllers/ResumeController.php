<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        // Use the native Upload API directly. This guarantees the upload works.
        $response = cloudinary()->uploadApi()->upload($request->file('file')->getRealPath(), [
            'folder' => 'grit_uploads'
        ]);

        Resume::create([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'file_url' => $response['secure_url'], // Get the secure URL from the API response
            'content_raw' => null,
            'is_active' => true,
        ]);

        return redirect()->route('resumes.index')->with('success', 'Resume uploaded successfully.');
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

        // Use the native Upload API to delete the file
        if (preg_match('/upload\/(?:v\d+\/)?(.+)\.[a-zA-Z]+$/', $resume->file_url, $matches)) {
            $publicId = $matches[1];
            cloudinary()->uploadApi()->destroy($publicId);
        }

        $resume->delete();

        return redirect()->route('resumes.index')->with('success', 'Resume deleted successfully.');
    }
}