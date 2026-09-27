<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userName;

    public function __construct($otp, $userName)
    {
        $this->otp = $otp;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('SpeedLane - Password Reset Verification Code')
                    ->html("
                        <div style='font-family: Arial, sans-serif; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; max-width: 500px; margin: 0 auto; background-color: #ffffff;'>
                            <h2 style='color: #0d6efd; margin-top: 0;'>SpeedLane Security Verification</h2>
                            <p style='color: #334155;'>Hello <strong>{$this->userName}</strong>,</p>
                            <p style='color: #334155;'>You requested a password change for your administrator account. Use the code below to authorize this update:</p>
                            
                            <div style='background-color: #f1f5f9; font-size: 32px; font-weight: bold; letter-spacing: 6px; padding: 18px; text-align: center; border-radius: 8px; color: #0d6efd; margin: 24px 0; border: 1px dashed #cbd5e1;'>
                                {$this->otp}
                            </div>
                            
                            <p style='color: #64748b; font-size: 13px; line-height: 1.5;'>
                                This verification code is valid for <strong>10 minutes</strong>.<br>
                                If you did not request this change, please secure your account immediately.
                            </p>
                        </div>
                    ");
    }
}