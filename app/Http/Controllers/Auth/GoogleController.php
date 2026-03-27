<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Added the Auth facade here
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google specifically for Logging In.
     */
    public function login()
    {
        session(['google_auth_intent' => 'login']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect the user to Google specifically for Registering.
     */
    public function register()
    {
        session(['google_auth_intent' => 'register']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the secure callback from Google.
     */
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/dashboard/login')->withErrors([
                'email' => 'Google authentication was cancelled or failed. Please try again.',
            ]);
        }

        $intent = session()->pull('google_auth_intent', 'login');

        $existingUser = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        // SCENARIO 1: USER IS TRYING TO LOG IN
        if ($intent === 'login') {
            if (!$existingUser) {
                return redirect('/dashboard/register')->withErrors([
                    'email' => 'No account found with this Google account. Please register first.',
                ]);
            }

            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);

            Auth::login($existingUser, true); // Fixed red line here
            return redirect('/dashboard');
        }

        // SCENARIO 2: USER IS TRYING TO REGISTER
        if ($intent === 'register') {
            if ($existingUser) {
                return redirect('/dashboard/login')->withErrors([
                    'email' => 'An account with this email already exists. Please log in instead.',
                ]);
            }

            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(32)),
                'api_token' => Str::random(60),
            ]);

            Auth::login($newUser, true); // Fixed red line here
            return redirect('/dashboard');
        }

        return redirect('/dashboard/login');
    }
}