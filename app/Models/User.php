<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'contact_number',
        'password',
        'role',
        'is_super_admin',
        'otp',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
            'otp_expires_at' => 'datetime',
        ];
    }

    /**
     * Check if the user is a Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        $role = strtolower(trim($this->role ?? ''));
        return (bool) $this->is_super_admin || in_array($role, ['super_admin', 'superadmin']);
    }

    /**
     * Check if the user is an Admin or Super Admin.
     */
    public function isAdmin(): bool
    {
        $role = strtolower(trim($this->role ?? ''));
        return $this->isSuperAdmin() || $role === 'admin';
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return strtolower(trim($this->role ?? '')) === strtolower(trim($role));
    }
}