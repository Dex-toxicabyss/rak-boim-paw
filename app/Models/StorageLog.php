<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageLog extends Model
{
    protected $fillable = [
        'log_code',
        'laundry_storage_id',
        'handled_by',
        'ironer_name',
        'verified_weight',
        'action_type',
        'logged_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'verified_weight' => 'decimal:2',
            'logged_at' => 'datetime',
        ];
    }

    public function storage(): BelongsTo
    {
        return $this->belongsTo(LaundryStorage::class, 'laundry_storage_id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public static function generateCode(): string
    {
        $prefix = 'LOG-' . now()->format('Ymd') . '-';
        $count = static::whereDate('created_at', today())->count() + 1;
        do {
            $code = $prefix . str_pad((string) $count, 3, '0', STR_PAD_LEFT);
            $count++;
        } while (static::where('log_code', $code)->exists());

        return $code;
    }
}
