<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $limitKey = 'update-profile:'.$request->user()->id;

        if (RateLimiter::tooManyAttempts($limitKey, 5)) {
            $seconds = RateLimiter::availableIn($limitKey);

            return Redirect::route('profile.edit')->with('error', 'Please wait '.$seconds.' seconds before trying again.');
        }

        RateLimiter::hit($limitKey, 60);

        $request->user()->fill($request->validated());
        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $limitKey = 'delete-account:'.$request->user()->id;

        if (RateLimiter::tooManyAttempts($limitKey, 5)) {
            return Redirect::route('profile.edit')->with('error', 'Too many attempts. Please try again later.');
        }

        RateLimiter::hit($limitKey, 60);

        $user = $request->user();

        if (is_null($user->google_id)) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Your account has been permanently deleted.');
    }
}
