<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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

        // Send Email via Brevo HTTP API (Port 443 - Bypasses Render SMTP Port Blocks)
        try {
            $response = Http::withHeaders([
                'api-key'      => env('BREVO_API_KEY'),
                'accept'       => 'application/json',
                'content-type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name'  => 'SpeedLane Admin',
                    'email' => env('MAIL_FROM_ADDRESS'),
                ],
                'to' => [
                    ['email' => $user->email]
                ],
                'subject'     => 'SpeedLane Admin - Password Reset OTP',
                'htmlContent' => "
                    <div style='font-family: Arial, sans-serif; padding: 20px;'>
                        <h2>SpeedLane Admin Password Reset</h2>
                        <p>Your OTP code is:</p>
                        <h1 style='color: #0d6efd; letter-spacing: 4px;'>{$otp}</h1>
                        <p>This code is valid for password recovery. Do not share this code with anyone.</p>
                    </div>
                "
            ]);

            if (!$response->successful()) {
                $errorMsg = $response->json('message') ?? 'Brevo API request failed.';
                throw new \Exception($errorMsg);
            }

        } catch (\Exception $e) {
            Log::error('Brevo Mail Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
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