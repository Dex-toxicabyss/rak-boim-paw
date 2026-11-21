<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaundryStorage extends Model
{
    protected $fillable = [
        'storage_code',
        'rack_id',
        'service_category_id',
        'staff_id',
        'customer_name',
        'customer_phone',
        'laundry_weight',
        'include_delivery',
        'total_price',
        'payment_status',
        'storage_status',
        'stored_at',
    ];

    protected function casts(): array
    {
        return [
            'laundry_weight' => 'decimal:2',
            'include_delivery' => 'boolean',
            'total_price' => 'decimal:2',
            'stored_at' => 'datetime',
        ];
    }

    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class);
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(StorageLog::class);
    }

    /**
     * Pencarian cepat (Nama / 4 digit terakhir telepon / No. Nota), filter rak & status, dan sorting.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['q'])) {
            $keyword = trim($filters['q']);
            $query->where(function (Builder $sub) use ($keyword) {
                $sub->where('customer_name', 'like', "%{$keyword}%")
                    ->orWhere('customer_phone', 'like', "%{$keyword}%")
                    ->orWhere('storage_code', 'like', "%{$keyword}%");
            });
        }

        if (!empty($filters['rack_id'])) {
            $query->where('rack_id', $filters['rack_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('storage_status', $filters['status']);
        }

        $sortMap = [
            'latest' => ['stored_at', 'desc'],
            'oldest' => ['stored_at', 'asc'],
            'name_asc' => ['customer_name', 'asc'],
            'weight_desc' => ['laundry_weight', 'desc'],
            'weight_asc' => ['laundry_weight', 'asc'],
        ];

        $sortKey = $filters['sort'] ?? 'latest';
        [$column, $direction] = $sortMap[$sortKey] ?? $sortMap['latest'];

        return $query->orderBy($column, $direction);
    }

    public static function generateCode(): string
    {
        $prefix = 'STR-' . now()->format('Ymd') . '-';
        $count = static::whereDate('created_at', today())->count() + 1;
        do {
            $code = $prefix . str_pad((string) $count, 3, '0', STR_PAD_LEFT);
            $count++;
        } while (static::where('storage_code', $code)->exists());

        return $code;
    }
}
