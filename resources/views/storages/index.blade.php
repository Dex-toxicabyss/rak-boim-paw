@extends('layouts.app')

@section('title', 'Penataan Rak')
@section('heading', 'Penataan Penyimpanan Cucian Rak')

@section('content')
<div class="rb-card p-3 mb-3">
    <form method="GET" action="{{ route('storages.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
            <label class="form-label small fw-semibold mb-1">Cari Nama / 4 Digit Terakhir Telp / Nota</label>
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control form-control-sm" placeholder="Contoh: Daniel atau 5459">
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">Filter ID Rak</label>
            <select name="rack_id" class="form-select form-select-sm">
                <option value="">Semua Rak</option>
                @foreach($racks as $rack)
                    <option value="{{ $rack->id }}" @selected(($filters['rack_id'] ?? '') == $rack->id)>{{ $rack->rack_code }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">Status</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="tersimpan" @selected(($filters['status'] ?? '') === 'tersimpan')>Tersimpan</option>
                <option value="siap_diambil" @selected(($filters['status'] ?? '') === 'siap_diambil')>Siap Diambil</option>
                <option value="selesai" @selected(($filters['status'] ?? '') === 'selesai')>Selesai</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">Urutkan</label>
            <select name="sort" class="form-select form-select-sm">
                <option value="latest" @selected(($filters['sort'] ?? 'latest') === 'latest')>Terbaru</option>
                <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Terlama</option>
                <option value="name_asc" @selected(($filters['sort'] ?? '') === 'name_asc')>Nama (A-Z)</option>
                <option value="weight_desc" @selected(($filters['sort'] ?? '') === 'weight_desc')>Berat Terbesar</option>
                <option value="weight_asc" @selected(($filters['sort'] ?? '') === 'weight_asc')>Berat Terkecil</option>
            </select>
        </div>
        <div class="col-6 col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-primary btn-sm flex-fill">Terapkan</button>
            <a href="{{ route('storages.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
    </form>
</div>

<div class="rb-card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="small text-muted">Menampilkan {{ $storages->count() }} dari {{ $storages->total() }} data cucian.</div>
        <a href="{{ route('storages.create') }}" class="btn btn-success btn-sm fw-semibold">+ Input Cucian</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nota &amp; Pelanggan</th>
                    <th>No. Telepon</th>
                    <th>Layanan</th>
                    <th class="text-end">Berat/Qty</th>
                    <th>ID Rak</th>
                    <th class="text-end">Total Biaya</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($storages as $row)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $row->customer_name }}</div>
                            <div class="small text-muted font-monospace">{{ $row->storage_code }}</div>
                        </td>
                        <td class="font-monospace small">{{ $row->customer_phone }}</td>
                        <td>
                            <div>{{ $row->serviceCategory->service_name }}</div>
                            @if($row->include_delivery)
                                <span class="badge text-bg-info">Jemput-Antar PP</span>
                            @endif
                        </td>
                        <td class="text-end tnum">{{ number_format($row->laundry_weight, 2, ',', '.') }} {{ $row->serviceCategory->unit_label }}</td>
                        <td><span class="badge text-bg-dark font-monospace">{{ $row->rack->rack_code }}</span></td>
                        <td class="text-end fw-semibold tnum">Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $row->storage_status === 'siap_diambil' ? 'text-bg-warning' : ($row->storage_status === 'selesai' ? 'text-bg-secondary' : 'text-bg-primary') }}">
                                {{ str_replace('_', ' ', ucfirst($row->storage_status)) }}
                            </span>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('storages.edit', $row) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            @if(auth()->user()->isPemilik())
                                <form method="POST" action="{{ route('storages.destroy', $row) }}" class="d-inline" onsubmit="return confirm('Hapus arsip cucian ini dari sistem?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Tidak ada data penyimpanan cucian yang sesuai pencarian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $storages->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
