@extends('layouts.app')

@section('title', 'Laporan')
@section('heading', 'Laporan Transaksi Gudang & Pendapatan')

@section('content')
<div class="rb-card p-3 mb-3">
    <form method="GET" action="{{ route('reports.index') }}" class="row g-2 align-items-end">
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold mb-1">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control form-control-sm">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold mb-1">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-6 d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary btn-sm">Filter Periode</button>
            <a href="{{ route('reports.csv', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success btn-sm">Export CSV</a>
            <a href="{{ route('reports.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-danger btn-sm">Export PDF</a>
        </div>
    </form>
</div>

<div class="rb-card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Nota</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th class="text-end">Berat/Qty</th>
                    <th>ID Rak</th>
                    <th class="text-end">Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $row)
                    <tr>
                        <td class="font-monospace small">{{ $row->storage_code }}</td>
                        <td class="small tnum">{{ $row->stored_at?->format('d/m/Y H:i') }}</td>
                        <td class="fw-semibold">{{ $row->customer_name }}</td>
                        <td>{{ $row->serviceCategory->service_name }}</td>
                        <td class="text-end tnum">{{ number_format($row->laundry_weight, 2, ',', '.') }} {{ $row->serviceCategory->unit_label }}</td>
                        <td><span class="badge text-bg-dark font-monospace">{{ $row->rack->rack_code }}</span></td>
                        <td class="text-end fw-semibold tnum">Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada transaksi pada periode tanggal terpilih.</td></tr>
                @endforelse
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="4" class="text-end">Total Periode ({{ $startDate }} s.d. {{ $endDate }}):</th>
                    <th class="text-end tnum">{{ number_format($totalWeight, 2, ',', '.') }} Kg/Unit</th>
                    <th></th>
                    <th class="text-end tnum text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
