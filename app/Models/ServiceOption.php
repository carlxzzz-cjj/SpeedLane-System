<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model
{
    use HasFactory;

    protected $table = 'service_options';

    protected $fillable = [
        'service_id',
        'name',
        'vehicle_type', // <-- MUST BE HERE
        'price',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}