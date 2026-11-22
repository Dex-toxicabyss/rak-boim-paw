@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Operasional')
@section('page_subtitle', 'Ringkasan cucian aktif, kapasitas rak, dan transaksi terbaru')

@section('topbar_actions')
    <a href="{{ route('storages.create') }}" class="btn-primary">+ Input Cucian ke Rak</a>
@endsection

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: var(--bg-ground);
        border: 1px solid var(--border-hairline);
        border-radius: var(--radius-lg);
        padding: 16px;
        box-shadow: var(--shadow-card);
    }

    .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--ink-muted);
    }

    .stat-value {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--ink-primary);
        margin-top: 6px;
    }

    .stat-sub {
        font-size: 11.5px;
        color: var(--ink-secondary);
        margin-top: 4px;
    }

    .section-card {
        background: var(--bg-ground);
        border: 1px solid var(--border-hairline);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .section-head {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .section-title {
        font-size: 14.5px;
        font-weight: 700;
        letter-spacing: -0.015em;
        color: var(--ink-primary);
    }

    .table-wrap {
        overflow-x: auto;
    }

    table.hig-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    table.hig-table th {
        text-align: left;
        padding: 10px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--ink-muted);
        background: var(--bg-subtle);
        border-bottom: 1px solid var(--border-light);
        white-space: nowrap;
    }

    table.hig-table td {
        padding: 11px 16px;
        border-bottom: 1px solid var(--border-light);
        color: var(--ink-secondary);
        white-space: nowrap;
    }

    table.hig-table tr:last-child td {
        border-bottom: none;
    }

    table.hig-table tbody tr:hover {
        background: var(--bg-subtle);
    }

    .occ-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 140px;
    }

    .occ-bar {
        flex: 1;
        height: 6px;
        border-radius: 999px;
        background: var(--bg-surface);
        overflow: hidden;
    }

    .occ-fill {
        height: 100%;
        border-radius: 999px;
        background: var(--accent);
    }

    .occ-fill.is-warn {
        background: var(--amber-ink);
    }

    .occ-fill.is-full {
        background: var(--red-ink);
    }

    .pill-status {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    .pill-green {
        background: var(--green-bg);
        color: var(--green-ink);
    }

    .pill-amber {
        background: var(--amber-bg);
        color: var(--amber-ink);
    }

    .pill-gray {
        background: var(--bg-surface);
        color: var(--ink-secondary);
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php
    $activeStoragesCount = $activeStoragesCount ?? (isset($recentStorages) ? $recentStorages->where('storage_status', '!=', 'selesai')->count() : 0);
    $totalLoadKg = $totalLoadKg ?? (isset($racks) ? collect($racks)->sum('current_load_kg') : 0);
    $readyPickupCount = $readyPickupCount ?? (isset($recentStorages) ? $recentStorages->where('storage_status', 'siap_diambil')->count() : 0);
    $totalRevenue = $totalRevenue ?? (isset($recentStorages) ? collect($recentStorages)->sum('total_price') : 0);
@endphp

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Cucian di Rak</div>
        <div class="stat-value mono">{{ $activeStoragesCount }} Bundel</div>
        <div class="stat-sub">Sedang tersimpan / siap diambil</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Beban Rak Aktif</div>
        <div class="stat-value mono">{{ number_format((float)$totalLoadKg, 2, ',', '.') }} Kg</div>
        <div class="stat-sub">Akumulasi seluruh rak aktif</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Siap Diambil</div>
        <div class="stat-value mono">{{ $readyPickupCount }} Pelanggan</div>
        <div class="stat-sub">Menunggu serah terima di kasir</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Omzet Tercatat</div>
        <div class="stat-value mono">Rp {{ number_format((float)$totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-sub">Dari data penyimpanan tercatat</div>
    </div>
</div>

<div class="section-card">
    <div class="section-head">
        <div class="section-title">Status Kapasitas Lemari &amp; Rak Gudang</div>
        <a href="{{ route('racks.index') }}" class="btn-secondary" style="padding:6px 11px; font-size:12px;">Kelola Rak</a>
    </div>

    <div class="table-wrap">
        <table class="hig-table">
            <thead>
                <tr>
                    <th>ID Rak</th>
                    <th>Lokasi</th>
                    <th>Beban Aktif</th>
                    <th>Kapasitas Maks</th>
                    <th>Okupansi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($racks ?? [] as $rack)
                    @php
                        $maxCap = max((float)$rack->max_capacity_kg, 1);
                        $pct = min(100, round(((float)$rack->current_load_kg / $maxCap) * 100));
                        $fillClass = $pct >= 95 ? 'is-full' : ($pct >= 75 ? 'is-warn' : '');
                        $rackStatus = $rack->status ?? 'tersedia';
                    @endphp
                    <tr>
                        <td class="mono" style="font-weight:600; color:var(--ink-primary);">{{ $rack->rack_code }}</td>
                        <td>Lemari {{ $rack->cabinet_number }} — Kolom {{ $rack->column_number }}</td>
                        <td class="mono">{{ number_format((float)$rack->current_load_kg, 2, ',', '.') }} Kg</td>
                        <td class="mono">{{ number_format((float)$rack->max_capacity_kg, 2, ',', '.') }} Kg</td>
                        <td>
                            <div class="occ-cell">
                                <div class="occ-bar">
                                    <div class="occ-fill {{ $fillClass }}" style="width: {{ $pct }}%;"></div>
                                </div>
                                <span class="mono" style="font-size:12px; color:var(--ink-primary);">{{ $pct }}%</span>
                            </div>
                        </td>
                        <td>
                            @if($rackStatus === 'penuh')
                                <span class="pill-status pill-amber">Penuh</span>
                            @elseif($rackStatus === 'perbaikan')
                                <span class="pill-status pill-gray">Perbaikan</span>
                            @else
                                <span class="pill-status pill-green">Tersedia</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:var(--ink-muted); padding:24px;">Belum ada data rak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="section-card">
    <div class="section-head">
        <div class="section-title">Penataan Rak Terbaru</div>
        <a href="{{ route('storages.index') }}" class="btn-secondary" style="padding:6px 11px; font-size:12px;">Lihat Semua</a>
    </div>

    <div class="table-wrap">
        <table class="hig-table">
            <thead>
                <tr>
                    <th>No. Nota</th>
                    <th>Pelanggan</th>
                    <th>No. Telp</th>
                    <th>ID Rak</th>
                    <th>Berat / Qty</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentStorages ?? [] as $row)
                    @php
                        $st = $row->storage_status ?? 'tersimpan';
                        $unit = optional($row->serviceCategory)->unit_label ?? 'Kg';
                    @endphp
                    <tr>
                        <td class="mono" style="font-weight:600; color:var(--ink-primary);">{{ $row->storage_code }}</td>
                        <td style="font-weight:600; color:var(--ink-primary);">{{ $row->customer_name }}</td>
                        <td class="mono">{{ $row->customer_phone }}</td>
                        <td class="mono">{{ optional($row->rack)->rack_code ?? '-' }}</td>
                        <td class="mono">{{ number_format((float)$row->laundry_weight, 2, ',', '.') }} {{ $unit }}</td>
                        <td>
                            @if($st === 'selesai')
                                <span class="pill-status pill-green">Selesai</span>
                            @elseif($st === 'siap_diambil')
                                <span class="pill-status pill-amber">Siap Diambil</span>
                            @else
                                <span class="pill-status pill-gray">Tersimpan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:var(--ink-muted); padding:24px;">Belum ada transaksi terbaru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
