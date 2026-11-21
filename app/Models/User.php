<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isPemilik(): bool
    {
        return $this->role === 'pemilik';
    }

    public function isStaf(): bool
    {
        return $this->role === 'staf';
    }

    public function storages(): HasMany
    {
        return $this->hasMany(LaundryStorage::class, 'staff_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(StorageLog::class, 'handled_by');
    }
}
