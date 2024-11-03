<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Laravel\Socialite\Facades\Socialite;
use App\Models\FacebookUser; // Make sure to import your FacebookUser model
use Exception;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        try {
            // Retrieve user details from Facebook
            $user = Socialite::driver('facebook')->stateless()->user();

            // Check if the user already exists in the facebook_users table
            $facebookUser = FacebookUser::where('facebook_id', $user->getId())->first();

            if ($facebookUser) {
                // Log the user in if they already exist
                Auth::login($facebookUser);
                return redirect()->route('facebook.seat.booking');  // Redirect to Facebook-specific seat booking
            } else {
                // Facebook user doesn't exist, create a new record
                $newFacebookUser = FacebookUser::create([
                    'facebook_id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                ]);

                // Log the new user in
                Auth::login($newFacebookUser);
                return redirect()->intended('facebook.seat.booking');  // Redirect to seat booking page
            }
        } catch (Exception $e) {
            // Log the exception and return with an error
            \Log::error('Facebook callback error: ' . $e->getMessage());

            return redirect()->route('login.view')
                ->withErrors(['facebook' => 'An error occurred while logging in with Facebook.']);
        }
    }
}
