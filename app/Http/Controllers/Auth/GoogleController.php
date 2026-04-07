<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication was cancelled or failed. Please try again.',
            ]);
        }

        $intent = session()->pull('google_auth_intent', 'login');

        $existingUser = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

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
            
            return redirect()->route('dashboard');
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
                'api_token' => Str::random(60),
            ]);

            Auth::login($newUser, true);
            
            return redirect()->route('dashboard');
        }

        return redirect()->route('login');
    }
}