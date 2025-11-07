<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    // Step 1 & 2 handled together
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function handleForm(Request $request)
    {
        // If only email submitted (step 1)
        if ($request->has('check_email')) {
            $request->validate(['email' => 'required|email']);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()
                    ->withErrors(['email' => 'No user found with this email.'])
                    ->withInput();
            }

            // Show password reset form
            return view('auth.forgot-password', [
                'emailFound' => true,
                'email' => $user->email,
            ]);
        }

        // If resetting password (step 2)
        if ($request->has('reset_password')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6|confirmed',
            ], [
                'password.confirmed' => 'Passwords do not match.',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['emailFound' => true, 'email' => $request->email]);
            }

            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login')->with('success', 'Password updated successfully. Please log in.');
        }

        // Fallback — go to main forgot password
        return redirect()->route('password.request');
    }
}
