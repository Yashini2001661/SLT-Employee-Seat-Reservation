<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Laravel\Socialite\Facades\Socialite;
use App\Models\GoogleUser; // Import your GoogleUser model
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Retrieve user details from Google
            $user = Socialite::driver('google')->stateless()->user();

            // Check if the user already exists in the google_users table
            $googleUser = GoogleUser::where('google_id', $user->getId())->first();

            if ($googleUser) {
                // Log the user in if they already exist
                Auth::login($googleUser);
                return redirect()->route('google.seat.booking');  // Redirect to your Google-specific seat booking page
            } else {
                // Google user doesn't exist, create a new record
                $newGoogleUser = GoogleUser::create([
                    'google_id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                ]);

                // Log the new user in
                Auth::login($newGoogleUser);
                return redirect()->route('google.seat.booking');  // Redirect to your Google-specific seat booking page
            }
        } catch (Exception $e) {
            // Log the exception and return with an error
            \Log::error('Google callback error: ' . $e->getMessage());

            return redirect()->route('login.view')->withErrors(['google' => 'An error occurred while logging in with Google.']);
        }
    }
}

