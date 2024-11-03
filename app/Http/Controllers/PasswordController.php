<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <-- Import Hash Facade
use App\Models\User; // Assuming you're using the User model to access Users table

class PasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        // Validate user input
        $request->validate([
            'emp_id' => 'required|string',
            'nic' => 'required|string',
            'newPassword' => 'required|string|min:8|confirmed', // Ensure newPassword matches confirmPassword
        ]);

        // Find the user by emp_id and NIC
        $user = User::where('emp_id', $request->emp_id)
                    ->where('nic', $request->nic)
                    ->first();

        if (!$user) {
            return back()->withErrors(['emp_id' => 'Invalid Employee ID or NIC.']);
        }

        // Hash and update the user's new password
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return redirect()->route('login.view')->with('status', 'Password changed successfully!');
    }

    public function showForgotPasswordForm()
    {
        return view('changepw'); // Ensure 'changepw.blade.php' exists
    }
}
