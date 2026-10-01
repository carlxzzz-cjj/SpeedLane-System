<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'notice',
        'vehicle_type',
        'selection_type',
        'flat_price',
        'is_active',
    ];

    public function options()
    {
        return $this->hasMany(ServiceOption::class);
    }
}