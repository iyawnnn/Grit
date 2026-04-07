<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleController extends Controller
{
    public function login()
    {
        session(['google_auth_intent' => 'login']);

        return Socialite::driver('google')->redirect();
    }

    public function register()
    {
        session(['google_auth_intent' => 'register']);

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            /** @var GoogleProvider $driver */
            $driver = Socialite::driver('google');
            $googleUser = $driver->stateless()->user();
        } catch (\Exception $e) {
            \Log::error('Google Auth Failed: '.$e->getMessage());

            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication failed. Please try again.',
            ]);
        }

        $intent = session()->pull('google_auth_intent', 'login');

        $existingUser = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($intent === 'login') {
            if (! $existingUser) {
                return redirect()->route('register')->withErrors([
                    'email' => 'No account found with this Google account. Please register first.',
                ]);
            }

            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);

            Auth::login($existingUser, true);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        if ($intent === 'register') {
            if ($existingUser) {
                return redirect()->route('login')->withErrors([
                    'email' => 'An account with this email already exists. Please log in instead.',
                ]);
            }

            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(32)),
            ]);

            Auth::login($newUser, true);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return redirect()->route('login');
    }
}
