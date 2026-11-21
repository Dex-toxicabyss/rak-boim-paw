<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    public const DELIVERY_FEE = 10000.00;

    protected $fillable = [
        'category_code',
        'service_type',
        'service_name',
        'unit_label',
        'price',
        'min_weight_kg',
        'estimated_hours',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'min_weight_kg' => 'decimal:2',
            'estimated_hours' => 'integer',
        ];
    }

    public function storages(): HasMany
    {
        return $this->hasMany(LaundryStorage::class);
    }

    public function isKiloan(): bool
    {
        return in_array($this->service_type, ['kiloan_reguler', 'kiloan_express'], true);
    }

    /**
     * Hitung otomatis total biaya transaksi.
     */
    public function calculateTotal(float $weightOrQty, bool $includeDelivery = false): float
    {
        $effectiveQty = $this->isKiloan()
            ? max($weightOrQty, (float) $this->min_weight_kg)
            : $weightOrQty;

        $subtotal = $effectiveQty * (float) $this->price;
        $delivery = $includeDelivery ? self::DELIVERY_FEE : 0.00;

        return round($subtotal + $delivery, 2);
    }
}
