<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Generate unique slug user{random_string}
     */
    private function generateUniqueSlug()
    {
        do {
            $randomString = Str::lower(Str::random(10));
            $slug = 'user' . $randomString;
        } while (User::where('slug', $slug)->exists());
        
        return $slug;
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();

        if(!$user)
        {
            // Generate username random (unique)
            $slug = $this->generateUniqueSlug();

            $user = User::create(
                ['name' => $googleUser->name,
                 'email' => $googleUser->email,
                 'slug' => $slug,
                 'password' => Hash::make(rand(100000,999999)),
                 'avatar_google' => $googleUser->avatar,
                ]
            );
        }

        if ($user->status === 'Banned') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been banned!');
        }

        Auth::login($user);

        return redirect('/');
    }
}
