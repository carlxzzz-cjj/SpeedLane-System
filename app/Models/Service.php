<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = ['name', 'description', 'notice', 'selection_type', 'flat_price', 'is_active'];

    public function options(): HasMany
    {
        return $this->hasMany(ServiceOption::class);
    }
}