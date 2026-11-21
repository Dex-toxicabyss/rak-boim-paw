<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rack extends Model
{
    protected $fillable = [
        'rack_code',
        'cabinet_number',
        'column_number',
        'max_capacity_kg',
        'current_load_kg',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'max_capacity_kg' => 'decimal:2',
            'current_load_kg' => 'decimal:2',
        ];
    }

    public function storages(): HasMany
    {
        return $this->hasMany(LaundryStorage::class);
    }

    /**
     * Hitung ulang beban aktif rak (kg) dari cucian yang belum diambil (status != selesai).
     */
    public function recalculateLoad(): void
    {
        $activeLoad = (float) $this->storages()
            ->whereIn('storage_status', ['tersimpan', 'siap_diambil'])
            ->sum('laundry_weight');

        $newStatus = $this->status;
        if ($this->status !== 'perbaikan') {
            $newStatus = $activeLoad >= (float) $this->max_capacity_kg ? 'penuh' : 'tersedia';
        }

        $this->update([
            'current_load_kg' => round($activeLoad, 2),
            'status' => $newStatus,
        ]);
    }

    public function occupancyPercent(): int
    {
        if ((float) $this->max_capacity_kg <= 0) {
            return 0;
        }
        return (int) min(100, round(((float) $this->current_load_kg / (float) $this->max_capacity_kg) * 100));
    }
}
