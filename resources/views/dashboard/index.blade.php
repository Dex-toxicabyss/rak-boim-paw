@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard Ringkas')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="rb-card p-3">
            <div class="small text-muted fw-semibold">Cucian di Rak</div>
            <div class="fs-3 fw-bold tnum mt-1">{{ $totalStoredBundles }} Bundel</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="rb-card p-3">
            <div class="small text-muted fw-semibold">Total Beban Rak Aktif</div>
            <div class="fs-3 fw-bold tnum mt-1">{{ number_format($totalActiveWeight, 2, ',', '.') }} Kg</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="rb-card p-3">
            <div class="small text-muted fw-semibold">Siap Diambil</div>
            <div class="fs-3 fw-bold tnum mt-1">{{ $readyForPickup }} Pelanggan</div>
        </div>
    </div>
    @if(auth()->user()->isPemilik())
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="rb-card p-3">
            <div class="small text-muted fw-semibold">Total Omzet Tercatat</div>
            <div class="fs-3 fw-bold tnum mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>
    @endif
</div>

<div class="rb-card p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h6 fw-bold mb-0">Status Kapasitas Lemari &amp; Rak Gudang</h2>
        <a href="{{ route('storages.create') }}" class="btn btn-primary btn-sm">+ Input Cucian ke Rak</a>
    </div>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID Rak</th>
                    <th>Lokasi</th>
                    <th class="text-end">Beban Aktif</th>
                    <th class="text-end">Kapasitas Maks</th>
                    <th style="width: 180px;">Okupansi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($racks as $rack)
                    @php $pct = $rack->occupancyPercent(); @endphp
                    <tr>
                        <td class="fw-semibold font-monospace">{{ $rack->rack_code }}</td>
                        <td>{{ $rack->cabinet_number }} — {{ $rack->column_number }}</td>
                        <td class="text-end tnum">{{ number_format($rack->current_load_kg, 2, ',', '.') }} Kg</td>
                        <td class="text-end tnum">{{ number_format($rack->max_capacity_kg, 2, ',', '.') }} Kg</td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar {{ $pct >= 90 ? 'bg-danger' : ($pct >= 70 ? 'bg-warning' : 'bg-primary') }}" style="width: {{ $pct }}%"></div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $rack->status === 'penuh' ? 'text-bg-danger' : ($rack->status === 'perbaikan' ? 'text-bg-secondary' : 'text-bg-success') }}">
                                {{ ucfirst($rack->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="rb-card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h6 fw-bold mb-0">Penataan Rak Terbaru</h2>
        <a href="{{ route('storages.index') }}" class="btn btn-outline-secondary btn-sm">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Nota</th>
                    <th>Pelanggan</th>
                    <th>No. Telp</th>
                    <th>ID Rak</th>
                    <th class="text-end">Berat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentStorages as $row)
                    <tr>
                        <td class="font-monospace small">{{ $row->storage_code }}</td>
                        <td class="fw-semibold">{{ $row->customer_name }}</td>
                        <td class="font-monospace small">{{ $row->customer_phone }}</td>
                        <td><span class="badge text-bg-dark font-monospace">{{ $row->rack->rack_code }}</span></td>
                        <td class="text-end tnum">{{ number_format($row->laundry_weight, 2, ',', '.') }} {{ $row->serviceCategory->unit_label }}</td>
                        <td>
                            <span class="badge {{ $row->storage_status === 'siap_diambil' ? 'text-bg-warning' : ($row->storage_status === 'selesai' ? 'text-bg-secondary' : 'text-bg-primary') }}">
                                {{ str_replace('_', ' ', ucfirst($row->storage_status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Belum ada transaksi penataan rak.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
