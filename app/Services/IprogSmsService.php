<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IprogSmsService
{
    protected string $apiToken;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(
            (string) config('services.iprog.api_url'),
            '/'
        );

        $this->apiToken = (string) config('services.iprog.api_token');
    }

    /**
     * Send an SMS through iProgSMS.
     */
    public function send(string $phoneNumber, string $message): bool
    {
        $cleanPhone = $this->formatPhoneNumber($phoneNumber);

        /*
         * Validate phone number.
         */
        if (empty($cleanPhone)) {
            Log::error(
                'iProg SMS dispatch skipped: Missing or invalid phone number.'
            );

            return false;
        }

        /*
         * Validate API token.
         */
        if (empty($this->apiToken)) {
            Log::error(
                'iProg SMS dispatch skipped: Missing API token.'
            );

            return false;
        }

        /*
         * Validate API URL.
         */
        if (empty($this->apiUrl)) {
            Log::error(
                'iProg SMS dispatch skipped: Missing API URL.'
            );

            return false;
        }

        Log::info(
            "iProg SMS dispatching -> Phone: {$cleanPhone} | Message: {$message}"
        );

        /*
         * iProgSMS API payload.
         */
        $payload = [
            'api_token'    => $this->apiToken,
            'phone_number' => $cleanPhone,
            'message'      => $message,
        ];

        try {
            /*
             * iProgSMS successfully accepted the SMS
             * using a POST request.
             */
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->asForm()
                ->post($this->apiUrl, $payload);

            /*
             * Log the complete API response.
             */
            Log::info(
                "iProg SMS API response [{$cleanPhone}]: " .
                "Status {$response->status()} | Body: {$response->body()}"
            );

            /*
             * HTTP request failed.
             */
            if (!$response->successful()) {
                Log::error(
                    "iProg SMS API error [{$cleanPhone}]: " .
                    "Status {$response->status()} | Body: {$response->body()}"
                );

                return false;
            }

            /*
             * Try to read the JSON response.
             */
            $responseData = $response->json();

            /*
             * iProgSMS normally returns:
             *
             * {
             *     "status": 200,
             *     "message": "SMS successfully queued for delivery.",
             *     "message_id": "..."
             * }
             *
             * Only treat the request as successful when
             * iProgSMS confirms that the SMS was queued.
             */
            if (
                is_array($responseData) &&
                isset($responseData['status']) &&
                (int) $responseData['status'] === 200
            ) {
                $messageId = $responseData['message_id'] ?? 'N/A';

                Log::info(
                    "iProg SMS queued successfully. " .
                    "Phone: {$cleanPhone} | Message ID: {$messageId}"
                );

                return true;
            }

            /*
             * HTTP request succeeded, but the API response
             * did not confirm that the SMS was queued.
             */
            Log::warning(
                "iProg SMS request completed, but the API did not " .
                "confirm successful queuing. " .
                "Phone: {$cleanPhone} | Body: {$response->body()}"
            );

            return false;

        } catch (\Throwable $e) {
            /*
             * Catch connection errors, timeout errors,
             * and unexpected exceptions.
             */
            Log::error(
                "iProg SMS Exception [{$phoneNumber}]: " .
                $e->getMessage()
            );

            return false;
        }
    }

    /**
     * Convert Philippine mobile numbers into
     * 63XXXXXXXXXX format.
     *
     * Examples:
     *
     * 09171234567   -> 639171234567
     * 9171234567    -> 639171234567
     * 639171234567  -> 639171234567
     */
    public function formatPhoneNumber(string $phoneNumber): string
    {
        /*
         * Remove spaces, dashes, parentheses,
         * plus signs, and other non-numeric characters.
         */
        $digits = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (!$digits) {
            return '';
        }

        /*
         * Philippine mobile number:
         * 09XXXXXXXXX
         *
         * Example:
         * 09171234567
         */
        if (
            strlen($digits) === 11 &&
            str_starts_with($digits, '09')
        ) {
            return '63' . substr($digits, 1);
        }

        /*
         * Philippine mobile number without leading 0:
         * 9XXXXXXXXX
         *
         * Example:
         * 9171234567
         */
        if (
            strlen($digits) === 10 &&
            str_starts_with($digits, '9')
        ) {
            return '63' . $digits;
        }

        /*
         * Already formatted:
         * 639XXXXXXXXX
         *
         * Example:
         * 639171234567
         */
        if (
            strlen($digits) === 12 &&
            str_starts_with($digits, '639')
        ) {
            return $digits;
        }

        /*
         * Return the cleaned number if it does not match
         * the expected Philippine formats.
         */
        return $digits;
    }
}