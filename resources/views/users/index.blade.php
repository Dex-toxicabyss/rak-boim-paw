@extends('layouts.app')

@section('title', 'Penataan Rak')
@section('page_title', 'Penataan Penyimpanan Cucian Rak')
@section('page_subtitle', 'Pencarian cepat 4 digit nomor telepon, filter rak, urutan data, dan serah terima')

@section('topbar_actions')
    <a href="{{ route('storages.create') }}" class="btn-primary">+ Input Cucian</a>
@endsection

@push('styles')
<style>
    .workspace-grid {
        display: grid;
        grid-template-columns: 268px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .panel-card {
        background: var(--bg-ground);
        border: 1px solid var(--border-hairline);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
    }

    .filter-col {
        background: var(--bg-surface);
        border: 1px solid var(--border-hairline);
        border-radius: var(--radius-lg);
        padding: 16px;
        position: sticky;
        top: 76px;
    }

    .filter-group {
        margin-bottom: 16px;
    }

    .filter-group:last-child {
        margin-bottom: 0;
    }

    .filter-title {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--ink-muted);
        margin-bottom: 8px;
    }

    .input-control,
    .select-control {
        width: 100%;
        padding: 8px 11px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-hairline);
        background: var(--bg-ground);
        color: var(--ink-primary);
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: border-color 150ms var(--ease-out);
    }

    .input-control:focus,
    .select-control:focus {
        border-color: var(--accent);
    }

    .radio-stack {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .radio-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--ink-secondary);
        cursor: pointer;
    }

    .rack-mini-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 8px;
    }

    .rack-mini-item {
        background: var(--bg-ground);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        padding: 8px 10px;
    }

    .rack-mini-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .progress-track {
        height: 5px;
        border-radius: 999px;
        background: var(--bg-surface);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--accent);
        border-radius: 999px;
    }

    .progress-fill.is-full {
        background: var(--red-ink);
    }

    .progress-fill.is-warn {
        background: var(--amber-ink);
    }

    /* Main Toolbar & Cards */
    .toolbar-card {
        padding: 14px 16px;
        margin-bottom: 16px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .pill-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .filter-pill {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 500;
        text-decoration: none;
        color: var(--ink-secondary);
        background: var(--bg-surface);
        border: 1px solid transparent;
        transition: all 150ms var(--ease-out);
    }

    .filter-pill:hover {
        background: var(--bg-hover);
        color: var(--ink-primary);
    }

    .filter-pill.is-active {
        background: var(--accent);
        color: #FFFFFF;
        font-weight: 600;
    }

    .sort-bar {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .storage-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .storage-card {
        background: var(--bg-ground);
        border: 1px solid var(--border-hairline);
        border-radius: var(--radius-lg);
        padding: 15px;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 12px;
        transition: border-color 160ms var(--ease-out), box-shadow 160ms var(--ease-out);
    }

    .storage-card:hover {
        border-color: #B8B8BE;
        box-shadow: var(--shadow-hover);
    }

    .card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .rack-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        background: var(--accent-soft);
        color: var(--accent);
        font-weight: 600;
        font-size: 11.5px;
    }

    .status-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-green {
        background: var(--green-bg);
        color: var(--green-ink);
    }

    .badge-amber {
        background: var(--amber-bg);
        color: var(--amber-ink);
    }

    .badge-red {
        background: var(--red-bg);
        color: var(--red-ink);
    }

    .badge-neutral {
        background: var(--bg-surface);
        color: var(--ink-secondary);
    }

    .customer-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--ink-primary);
        letter-spacing: -0.015em;
        margin-top: 8px;
    }

    .customer-phone {
        font-size: 12.5px;
        color: var(--ink-muted);
        margin-top: 2px;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
        padding-top: 10px;
        border-top: 1px solid var(--border-light);
        font-size: 12px;
    }

    .meta-label {
        color: var(--ink-muted);
        font-size: 11px;
    }

    .meta-val {
        color: var(--ink-primary);
        font-weight: 600;
        margin-top: 1px;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-top: 10px;
        border-top: 1px solid var(--border-light);
    }

    .card-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: var(--ink-muted);
    }

    @media (max-width: 1180px) {
        .storage-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .workspace-grid {
            grid-template-columns: 1fr;
        }

        .filter-col {
            position: static;
        }

        .storage-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php
    $currentUser = auth()->user();
    $isOwner = $currentUser && method_exists($currentUser, 'isPemilik') ? $currentUser->isPemilik() : (($currentUser->role ?? '') === 'pemilik');
    $activeStatus = request('status', '');
    $activeRack = request('rack_id', '');
    $activePayment = request('payment_status', '');
    $activeSort = request('sort', 'latest');
    $searchQuery = request('q', '');
@endphp

<div class="workspace-grid">
    {{-- Kolom Filter Kiri --}}
    <form method="GET" action="{{ route('storages.index') }}" class="filter-col">
        @if($activeStatus)
            <input type="hidden" name="status" value="{{ $activeStatus }}">
        @endif
        @if($activeSort)
            <input type="hidden" name="sort" value="{{ $activeSort }}">
        @endif

        <div class="filter-group">
            <div class="filter-title">Cari Nota / 4 Digit Telp</div>
            <input
                type="text"
                name="q"
                value="{{ $searchQuery }}"
                placeholder="Contoh: 4920, Budi, STR-..."
                class="input-control mono"
            >
        </div>

        <div class="filter-group">
            <div class="filter-title">Filter ID Rak</div>
            <select name="rack_id" class="select-control">
                <option value="">Semua Rak</option>
                @foreach($racks ?? [] as $rack)
                    <option value="{{ $rack->id }}" {{ (string)$activeRack === (string)$rack->id ? 'selected' : '' }}>
                        {{ $rack->rack_code }} ({{ number_format($rack->current_load_kg, 1) }}/{{ number_format($rack->max_capacity_kg, 0) }} kg)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <div class="filter-title">Status Pembayaran</div>
            <div class="radio-stack">
                <label class="radio-row">
                    <input type="radio" name="payment_status" value="" {{ $activePayment === '' ? 'checked' : '' }}>
                    <span>Semua Pembayaran</span>
                </label>
                <label class="radio-row">
                    <input type="radio" name="payment_status" value="lunas" {{ $activePayment === 'lunas' ? 'checked' : '' }}>
                    <span>Lunas</span>
                </label>
                <label class="radio-row">
                    <input type="radio" name="payment_status" value="belum_lunas" {{ $activePayment === 'belum_lunas' ? 'checked' : '' }}>
                    <span>Belum Lunas</span>
                </label>
            </div>
        </div>

        <div style="display:flex; gap:8px; margin-bottom:16px;">
            <button type="submit" class="btn-primary" style="flex:1;">Terapkan</button>
            <a href="{{ route('storages.index') }}" class="btn-secondary">Reset</a>
        </div>

        @if(!empty($racks) && count($racks) > 0)
            <div class="filter-group">
                <div class="filter-title">Okupansi Rak</div>
                <div class="rack-mini-list">
                    @foreach($racks as $rack)
                        @php
                            $maxCap = max((float)$rack->max_capacity_kg, 1);
                            $pct = min(100, round(((float)$rack->current_load_kg / $maxCap) * 100));
                            $barClass = $pct >= 95 ? 'is-full' : ($pct >= 75 ? 'is-warn' : '');
                        @endphp
                        <div class="rack-mini-item">
                            <div class="rack-mini-top">
                                <span class="mono" style="font-weight:600; color:var(--ink-primary);">{{ $rack->rack_code }}</span>
                                <span class="mono" style="color:var(--ink-muted);">{{ $pct }}%</span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill {{ $barClass }}" style="width: {{ $pct }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </form>

    {{-- Kolom Utama Kanan --}}
    <div>
        <div class="panel-card toolbar-card">
            <div class="pill-strip">
                <a href="{{ route('storages.index', array_filter(['q' => $searchQuery, 'rack_id' => $activeRack, 'payment_status' => $activePayment, 'sort' => $activeSort])) }}"
                   class="filter-pill {{ $activeStatus === '' ? 'is-active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('storages.index', array_filter(['status' => 'tersimpan', 'q' => $searchQuery, 'rack_id' => $activeRack, 'payment_status' => $activePayment, 'sort' => $activeSort])) }}"
                   class="filter-pill {{ $activeStatus === 'tersimpan' ? 'is-active' : '' }}">
                    Tersimpan
                </a>
                <a href="{{ route('storages.index', array_filter(['status' => 'siap_diambil', 'q' => $searchQuery, 'rack_id' => $activeRack, 'payment_status' => $activePayment, 'sort' => $activeSort])) }}"
                   class="filter-pill {{ $activeStatus === 'siap_diambil' ? 'is-active' : '' }}">
                    Siap Diambil
                </a>
                <a href="{{ route('storages.index', array_filter(['status' => 'selesai', 'q' => $searchQuery, 'rack_id' => $activeRack, 'payment_status' => $activePayment, 'sort' => $activeSort])) }}"
                   class="filter-pill {{ $activeStatus === 'selesai' ? 'is-active' : '' }}">
                    Selesai
                </a>
            </div>

            <form method="GET" action="{{ route('storages.index') }}" class="sort-bar">
                @if($searchQuery)<input type="hidden" name="q" value="{{ $searchQuery }}">@endif
                @if($activeRack)<input type="hidden" name="rack_id" value="{{ $activeRack }}">@endif
                @if($activePayment)<input type="hidden" name="payment_status" value="{{ $activePayment }}">@endif
                @if($activeStatus)<input type="hidden" name="status" value="{{ $activeStatus }}">@endif

                <span style="font-size:12px; color:var(--ink-muted);">Urutkan:</span>
                <select name="sort" onchange="this.form.submit()" class="select-control" style="width:auto; padding:6px 10px; font-size:12.5px;">
                    <option value="latest" {{ $activeSort === 'latest' ? 'selected' : '' }}>Terbaru Masuk</option>
                    <option value="oldest" {{ $activeSort === 'oldest' ? 'selected' : '' }}>Terlama di Rak</option>
                    <option value="heaviest" {{ $activeSort === 'heaviest' ? 'selected' : '' }}>Berat Terbesar</option>
                    <option value="name_asc" {{ $activeSort === 'name_asc' ? 'selected' : '' }}>Nama Pelanggan (A–Z)</option>
                </select>
            </form>
        </div>

        @if(isset($storages) && count($storages) > 0)
            <div class="storage-grid">
                @foreach($storages as $item)
                    @php
                        $st = $item->storage_status ?? 'tersimpan';
                        $pay = $item->payment_status ?? 'belum_lunas';
                        $statusBadgeClass = match($st) {
                            'selesai' => 'badge-green',
                            'siap_diambil' => 'badge-amber',
                            default => 'badge-neutral',
                        };
                        $statusLabel = match($st) {
                            'selesai' => 'Selesai',
                            'siap_diambil' => 'Siap Diambil',
                            default => 'Tersimpan',
                        };
                        $serviceName = optional($item->serviceCategory)->service_name ?? 'Layanan Laundry';
                        $isExpress = str_contains(strtolower($serviceName), 'express') || (($item->serviceCategory->service_type ?? '') === 'kiloan_express');
                    @endphp

                    <article class="storage-card">
                        <div>
                            <div class="card-top">
                                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                    <span class="rack-badge mono">{{ optional($item->rack)->rack_code ?? 'TANPA RAK' }}</span>
                                    @if($isExpress)
                                        <span class="status-badge badge-red">Express</span>
                                    @endif
                                </div>
                                <span class="status-badge {{ $statusBadgeClass }}">{{ $statusLabel }}</span>
                            </div>

                            <div class="customer-name">{{ $item->customer_name }}</div>
                            <div class="customer-phone mono">
                                {{ $item->customer_phone }} • <span style="font-size:11.5px;">{{ $item->storage_code }}</span>
                            </div>

                            <div class="meta-grid" style="margin-top:12px;">
                                <div>
                                    <div class="meta-label">Layanan</div>
                                    <div class="meta-val">{{ $serviceName }}</div>
                                </div>
                                <div>
                                    <div class="meta-label">Berat / Qty</div>
                                    <div class="meta-val mono">{{ number_format((float)$item->laundry_weight, 1) }} kg</div>
                                </div>
                                <div>
                                    <div class="meta-label">Total Biaya</div>
                                    <div class="meta-val mono">Rp {{ number_format((float)$item->total_price, 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="meta-label">Pembayaran</div>
                                    <div class="meta-val">
                                        @if($pay === 'lunas')
                                            <span style="color:var(--green-ink);">Lunas</span>
                                        @else
                                            <span style="color:var(--amber-ink);">Belum Lunas</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <span class="mono" style="font-size:11px; color:var(--ink-muted);">
                                {{ optional($item->stored_at ?? $item->created_at)->format('d M H:i') }}
                            </span>

                            <div class="card-actions">
                                <a href="{{ route('storages.edit', $item) }}" class="btn-secondary" style="padding:5px 10px; font-size:12px;">
                                    Kelola
                                </a>

                                @if($isOwner)
                                    <form method="POST" action="{{ route('storages.destroy', $item) }}" onsubmit="return confirm('Hapus data penyimpanan {{ $item->storage_code }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-ghost" style="padding:5px 9px; font-size:11.5px;">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if(method_exists($storages, 'links'))
                <div style="margin-top:18px;">
                    {{ $storages->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="panel-card empty-state">
                <div style="font-weight:600; color:var(--ink-primary); margin-bottom:4px;">Belum ada data cucian yang cocok</div>
                <div style="font-size:13px;">Coba ubah kata kunci pencarian atau reset filter di panel kiri.</div>
            </div>
        @endif
    </div>
</div>
@endsection