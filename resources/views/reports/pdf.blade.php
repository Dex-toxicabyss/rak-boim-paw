<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rak Boim ({{ $startDate }} s.d. {{ $endDate }})</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111827; margin: 24px; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .meta { color: #4B5563; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #CBD5E1; padding: 6px 8px; text-align: left; }
        th { background-color: #F1F5F9; }
        .text-right { text-align: right; }
        .no-print { margin-bottom: 16px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    </div>
    <h1>LAPORAN TRANSAKSI GUDANG &amp; PENDAPATAN — RAK BOIM</h1>
    <div class="meta">Mitra: Boim Laundry (Mr. Boim Laundry) | Periode: {{ $startDate }} s.d. {{ $endDate }}</div>

    <table>
        <thead>
            <tr>
                <th>No. Nota</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th class="text-right">Berat/Qty</th>
                <th>ID Rak</th>
                <th class="text-right">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $row)
                <tr>
                    <td>{{ $row->storage_code }}</td>
                    <td>{{ $row->stored_at?->format('d/m/Y H:i') }}</td>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ $row->serviceCategory->service_name }}</td>
                    <td class="text-right">{{ number_format($row->laundry_weight, 2, ',', '.') }} {{ $row->serviceCategory->unit_label }}</td>
                    <td>{{ $row->rack->rack_code }}</td>
                    <td class="text-right">Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total</th>
                <th class="text-right">{{ number_format($totalWeight, 2, ',', '.') }}</th>
                <th></th>
                <th class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
