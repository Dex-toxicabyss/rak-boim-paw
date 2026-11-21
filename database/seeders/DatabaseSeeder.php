<?php

namespace Database\Seeders;

use App\Models\LaundryStorage;
use App\Models\Rack;
use App\Models\ServiceCategory;
use App\Models\StorageLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Master User (Pemilik & Staf)
        $pemilik = User::updateOrCreate(
            ['email' => 'pemilik@boimlaundry.test'],
            [
                'name' => 'Pak Boim (Pemilik)',
                'password' => Hash::make('password123'),
                'phone' => '081200000001',
                'role' => 'pemilik',
                'is_active' => true,
            ]
        );

        $staf = User::updateOrCreate(
            ['email' => 'staf@boimlaundry.test'],
            [
                'name' => 'Rina (Staf Kasir)',
                'password' => Hash::make('password123'),
                'phone' => '081200000002',
                'role' => 'staf',
                'is_active' => true,
            ]
        );

        // 2. Master ID Rak & Lemari Gudang Belakang
        $racksData = [
            ['rack_code' => 'RAK-01-K1', 'cabinet_number' => 'Lemari 1', 'column_number' => 'Kolom 1', 'max_capacity_kg' => 50.00],
            ['rack_code' => 'RAK-01-K2', 'cabinet_number' => 'Lemari 1', 'column_number' => 'Kolom 2', 'max_capacity_kg' => 50.00],
            ['rack_code' => 'RAK-02-K1', 'cabinet_number' => 'Lemari 2', 'column_number' => 'Kolom 1', 'max_capacity_kg' => 50.00],
            ['rack_code' => 'RAK-02-K2', 'cabinet_number' => 'Lemari 2', 'column_number' => 'Kolom 2', 'max_capacity_kg' => 50.00],
            ['rack_code' => 'RAK-03-K1', 'cabinet_number' => 'Lemari 3', 'column_number' => 'Kolom 1', 'max_capacity_kg' => 50.00],
            ['rack_code' => 'RAK-03-K2', 'cabinet_number' => 'Lemari 3', 'column_number' => 'Kolom 2', 'max_capacity_kg' => 50.00],
        ];

        $racks = [];
        foreach ($racksData as $row) {
            $racks[$row['rack_code']] = Rack::updateOrCreate(
                ['rack_code' => $row['rack_code']],
                $row
            );
        }

        // 3. Master Tarif Layanan Resmi Mr. Boim Laundry (13 Kiloan/Express/PP + 23 Satuan)
        $servicesData = [
            // Kiloan Reguler (min 2 kg)
            ['SRV-REG-CS', 'kiloan_reguler', 'Cuci + Setrika', 'Kg', 8000, 2.00, 48],
            ['SRV-REG-CL', 'kiloan_reguler', 'Cuci + Lipat', 'Kg', 6000, 2.00, 48],
            ['SRV-REG-SS', 'kiloan_reguler', 'Setrika Saja', 'Kg', 6000, 2.00, 48],

            // Express 24 Jam (2x tarif, min 2 kg)
            ['SRV-EXP24-CS', 'kiloan_express', 'Express 24 Jam — Cuci + Setrika', 'Kg', 16000, 2.00, 24],
            ['SRV-EXP24-CL', 'kiloan_express', 'Express 24 Jam — Cuci + Lipat', 'Kg', 12000, 2.00, 24],
            ['SRV-EXP24-SS', 'kiloan_express', 'Express 24 Jam — Setrika Saja', 'Kg', 12000, 2.00, 24],

            // Express 8 Jam (3x tarif, min 2 kg)
            ['SRV-EXP8-CS', 'kiloan_express', 'Express 8 Jam — Cuci + Setrika', 'Kg', 24000, 2.00, 8],
            ['SRV-EXP8-CL', 'kiloan_express', 'Express 8 Jam — Cuci + Lipat', 'Kg', 18000, 2.00, 8],
            ['SRV-EXP8-SS', 'kiloan_express', 'Express 8 Jam — Setrika Saja', 'Kg', 18000, 2.00, 8],

            // Express 4 Jam (4x tarif, min 2 kg)
            ['SRV-EXP4-CS', 'kiloan_express', 'Express 4 Jam — Cuci + Setrika', 'Kg', 32000, 2.00, 4],
            ['SRV-EXP4-CL', 'kiloan_express', 'Express 4 Jam — Cuci + Lipat', 'Kg', 24000, 2.00, 4],
            ['SRV-EXP4-SS', 'kiloan_express', 'Express 4 Jam — Setrika Saja', 'Kg', 24000, 2.00, 4],

            // Layanan Tambahan
            ['SRV-DLV-PP', 'tambahan', 'Layanan Jemput - Antar (PP)', 'Transaksi', 10000, 0.00, 24],

            // 23 Item Harga Satuan Resmi Mr. Boim Laundry
            ['SAT-01', 'satuan', 'Bedcover Kecil', 'Pcs', 25000, 1.00, 72],
            ['SAT-02', 'satuan', 'Bedcover Besar', 'Pcs', 35000, 1.00, 72],
            ['SAT-03', 'satuan', 'Celana', 'Pcs', 15000, 1.00, 48],
            ['SAT-04', 'satuan', 'Dress Pendek', 'Pcs', 20000, 1.00, 48],
            ['SAT-05', 'satuan', 'Dress Panjang', 'Pcs', 25000, 1.00, 48],
            ['SAT-06', 'satuan', 'Gamis', 'Pcs', 20000, 1.00, 48],
            ['SAT-07', 'satuan', 'Gorden', 'Meter', 10000, 1.00, 72],
            ['SAT-08', 'satuan', 'Jaket', 'Pcs', 20000, 1.00, 48],
            ['SAT-09', 'satuan', 'Jas', 'Pcs', 40000, 1.00, 72],
            ['SAT-10', 'satuan', 'Jilbab', 'Pcs', 15000, 1.00, 48],
            ['SAT-11', 'satuan', 'Kaos', 'Pcs', 15000, 1.00, 48],
            ['SAT-12', 'satuan', 'Kemeja', 'Pcs', 15000, 1.00, 48],
            ['SAT-13', 'satuan', 'Keset', 'Pcs', 10000, 1.00, 48],
            ['SAT-14', 'satuan', 'Mukena', 'Pcs', 20000, 1.00, 48],
            ['SAT-15', 'satuan', 'Sajadah', 'Pcs', 15000, 1.00, 48],
            ['SAT-16', 'satuan', 'Sarung', 'Pcs', 15000, 1.00, 48],
            ['SAT-17', 'satuan', 'Selimut', 'Pcs', 15000, 1.00, 72],
            ['SAT-18', 'satuan', 'Sprei', 'Pcs', 15000, 1.00, 48],
            ['SAT-19', 'satuan', 'Sprei Set', 'Set', 20000, 1.00, 48],
            ['SAT-20', 'satuan', 'Tas Gunung', 'Pcs', 35000, 1.00, 72],
            ['SAT-21', 'satuan', 'Tas Ransel', 'Pcs', 20000, 1.00, 72],
            ['SAT-22', 'satuan', 'Topi', 'Pcs', 20000, 1.00, 48],
            ['SAT-23', 'satuan', 'Sepatu', 'Pasang', 45000, 1.00, 72],
        ];

        $services = [];
        foreach ($servicesData as [$code, $type, $name, $unit, $price, $minW, $hours]) {
            $services[$code] = ServiceCategory::updateOrCreate(
                ['category_code' => $code],
                [
                    'service_type' => $type,
                    'service_name' => $name,
                    'unit_label' => $unit,
                    'price' => $price,
                    'min_weight_kg' => $minW,
                    'estimated_hours' => $hours,
                ]
            );
        }

        // 4. Contoh Transaksi Penataan Rak (sesuai skenario uji Black Box & Laporan)
        $samples = [
            [
                'storage_code' => 'STR-20261119-001',
                'rack_id' => $racks['RAK-03-K2']->id,
                'service_category_id' => $services['SRV-REG-CS']->id,
                'staff_id' => $staf->id,
                'customer_name' => 'Daniel',
                'customer_phone' => '081298765459',
                'laundry_weight' => 3.83,
                'include_delivery' => true,
                'payment_status' => 'lunas',
                'storage_status' => 'siap_diambil',
                'ironer_name' => 'Siti (Setrika)',
            ],
            [
                'storage_code' => 'STR-20261119-002',
                'rack_id' => $racks['RAK-01-K1']->id,
                'service_category_id' => $services['SRV-REG-CS']->id,
                'staff_id' => $staf->id,
                'customer_name' => 'Agus',
                'customer_phone' => '085711223344',
                'laundry_weight' => 4.50,
                'include_delivery' => false,
                'payment_status' => 'belum_lunas',
                'storage_status' => 'tersimpan',
                'ironer_name' => 'Siti (Setrika)',
            ],
            [
                'storage_code' => 'STR-20261118-003',
                'rack_id' => $racks['RAK-02-K1']->id,
                'service_category_id' => $services['SRV-EXP24-CS']->id,
                'staff_id' => $staf->id,
                'customer_name' => 'Siti Rahma',
                'customer_phone' => '081344556677',
                'laundry_weight' => 2.50,
                'include_delivery' => false,
                'payment_status' => 'lunas',
                'storage_status' => 'tersimpan',
                'ironer_name' => 'Wati (Setrika)',
            ],
            [
                'storage_code' => 'STR-20261118-004',
                'rack_id' => $racks['RAK-01-K2']->id,
                'service_category_id' => $services['SAT-02']->id,
                'staff_id' => $pemilik->id,
                'customer_name' => 'Rina Wulandari',
                'customer_phone' => '082199887766',
                'laundry_weight' => 1.00,
                'include_delivery' => false,
                'payment_status' => 'lunas',
                'storage_status' => 'siap_diambil',
                'ironer_name' => 'Wati (Setrika)',
            ],
        ];

        foreach ($samples as $idx => $item) {
            $service = ServiceCategory::find($item['service_category_id']);
            $totalPrice = $service->calculateTotal((float) $item['laundry_weight'], (bool) $item['include_delivery']);
            $ironerName = $item['ironer_name'];
            unset($item['ironer_name']);

            $storage = LaundryStorage::updateOrCreate(
                ['storage_code' => $item['storage_code']],
                array_merge($item, [
                    'total_price' => $totalPrice,
                    'stored_at' => now()->subHours(($idx + 1) * 4),
                ])
            );

            StorageLog::updateOrCreate(
                ['log_code' => 'LOG-20261119-00' . ($idx + 1)],
                [
                    'laundry_storage_id' => $storage->id,
                    'handled_by' => $storage->staff_id,
                    'ironer_name' => $ironerName,
                    'verified_weight' => $storage->laundry_weight,
                    'action_type' => 'masuk_rak',
                    'logged_at' => $storage->stored_at,
                    'notes' => 'Penataan awal bundel cucian selesai ke rak ' . $storage->rack->rack_code,
                ]
            );
        }

        // Hitung ulang beban kapasitas semua rak
        Rack::all()->each->recalculateLoad();
    }
}
