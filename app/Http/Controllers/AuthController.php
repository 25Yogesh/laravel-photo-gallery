<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'address' => ['nullable', 'string', 'max:500'],
            'user_id' => ['required', 'alpha_num', 'min:4', 'max:50', 'unique:users,user_id'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'full_name' => $data['full_name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'user_id' => $data['user_id'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('gallery.index')->with('success', 'Registration successful');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login: uses user_id + password as requested
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['user_id' => $credentials['user_id'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('gallery.index'));
        }

        return back()->withErrors(['user_id' => 'The provided credentials do not match our records.'])->onlyInput('user_id');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out');
    }
}
