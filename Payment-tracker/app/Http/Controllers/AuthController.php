<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialite = Socialite::driver('google');
            $socialite->stateless()->setHttpClient(new \GuzzleHttp\Client([
                'verify' => false,
            ]));

            $googleUser = $socialite->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(uniqid()),
                ]
            );

            Auth::login($user);
            return redirect('/dashboard');

        } catch (\Exception $e) {
            return redirect('/');
        }
    }

// app/Http/Controllers/AuthController.php
    public function dashboard()
    {
        // Alleen betalingen van de ingelogde gebruiker ophalen
        $payments = auth()->user()->payments()->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('payments'));
    }

}
