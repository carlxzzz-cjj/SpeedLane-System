<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AdminPasswordResetController extends Controller
{
    /**
     * Send OTP to the registered Gmail account associated with the username.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ], [
            'username.required' => 'Please enter your account username.',
        ]);

        // Find user by username or email
        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

        if (!$user || !$user->email) {
            return response()->json([
                'success' => false,
                'message' => 'No registered account found with that username.'
            ], 404);
        }

        // Generate 6-digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));

        // Save hashed OTP in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token'      => Hash::make($otp),
                'created_at' => now()
            ]
        );

        // Send actual Email via Mail driver
        try {
            Mail::raw("Your SpeedLane Admin password reset OTP code is: {$otp}\n\nThis code is valid for password recovery. Do not share this code with anyone.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('SpeedLane Admin - Password Reset OTP');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Check your .env mail configuration. Error: ' . $e->getMessage()
            ], 422);
        }

        // Mask email for display security (e.g. ma***ay@gmail.com)
        $parts = explode('@', $user->email);
        $maskedEmail = strlen($parts[0]) > 2 
            ? substr($parts[0], 0, 2) . str_repeat('*', strlen($parts[0]) - 2) . '@' . $parts[1]
            : $parts[0] . '@' . $parts[1];

        return response()->json([
            'success' => true,
            'message' => 'OTP code sent to registered Gmail (' . $maskedEmail . ').',
            'username' => $user->username
        ]);
    }

    /**
     * Verify OTP and reset user password.
     */
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'otp'      => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'User account not found.'], 404);
            }
            return back()->with('error', 'User account not found.');
        }

        $record = DB::table('password_reset_tokens')->where('email', $user->email)->first();

        if (!$record || !Hash::check($request->otp, $record->token)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Invalid or expired OTP code.'], 422);
            }
            return back()->with('error', 'Invalid or expired OTP code.');
        }

        // Update account password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete token after successful update
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Password reset successfully!']);
        }

        return back()->with('success', 'Password reset successfully!');
    }
}