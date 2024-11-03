<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('emp_id', 'password');

        // Check if credentials are valid
        if (Auth::attempt($credentials)) {
            // Redirect to seat booking page after successful login
            return redirect()->route('seat.booking');
        }

        // Authentication failed
        return back()->withErrors([
            'emp_id' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token for security
        
        return redirect()->route('login.view'); // Redirect to the home page after logout
    }

    // Ensure this function is inside the class but the use statement is already at the top
    public function changePassword(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|string',
            'nic' => 'required|string',
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:6', // You can adjust the password length
        ]);

        // Check if the user exists
        $user = User::where('emp_id', $request->emp_id)
                    ->where('nic', $request->nic)
                    ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Invalid Employee ID or NIC.']);
        }

        // Check if the current password is correct
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Current password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->newPassword); // Hash the new password
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password changed successfully.']);
    }

}

