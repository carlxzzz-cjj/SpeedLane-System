<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    use HasFactory;

    protected $table = 'service_records';

    protected $fillable = [
        'tracking_code',
        'customer_name',
        'contact_number',
        'vehicle_make',
        'vehicle_model',
        'vehicle_type',
        'vehicle_year',
        'plate_number',
        'selected_services',
        'selected_services_prices',
        'price_adjustment_note',
        'total_cost',
        'mechanic_assigned',
        'status',
    ];

    protected $casts = [
        'selected_services'        => 'array',
        'selected_services_prices' => 'array',
        'total_cost'               => 'decimal:2',
    ];

    /**
     * Get a formatted vehicle description (e.g., "2022 Toyota Vios").
     */
    public function getFormattedVehicleAttribute(): string
    {
        return trim("{$this->vehicle_year} {$this->vehicle_make} {$this->vehicle_model}");
    }

    /**
     * Generate a unique tracking code (Format: SPDYY-XXXXXX)
     */
    public static function generateUniqueTrackingCode(): string
    {
        do {
            $code = 'SPD' . date('y') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        } while (self::where('tracking_code', $code)->exists());

        return $code;
    }
}