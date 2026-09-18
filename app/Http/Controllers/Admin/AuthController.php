<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Process New HR / Admin Account Registration 
     * (Accessible ONLY from within the protected Admin Dashboard)
     */
    public function register(Request $request)
    {
        // 1. Validate Form Inputs (Matches all required fields + confirmation)
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users,email',
            'contact_number' => 'required|string|max:20',
            'username'       => 'required|string|max:50|unique:users,username',
            'password'       => 'required|string|min:8|confirmed',
        ]);

        // 2. Save Admin/HR Account into MySQL 'users' Table
        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'username'       => $request->username,
            'password'       => Hash::make($request->password), // Encrypts password securely
        ]);

        // 3. Redirect back to Dashboard with Success Toast / Message
        return redirect()->back()->with('success', 'New HR/Admin account registered successfully!');
    }

    /**
     * Display Login View Page
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Process Admin Login Credentials
     */
    public function login(Request $request)
    {
        // 1. Validate Login Inputs
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Authenticate User against Database
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Return Error on Incorrect Credentials
        return back()->withInput()->withErrors([
            'username' => 'The provided username or password is incorrect.',
        ]);
    }

    /**
     * Logout Admin Session
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }
}   