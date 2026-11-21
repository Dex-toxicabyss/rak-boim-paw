@extends('layouts.app')

@section('title', $rack->exists ? 'Edit ID Rak' : 'Tambah ID Rak')
@section('heading', $rack->exists ? 'Edit Master ID Rak' : 'Tambah Master ID Rak Baru')

@section('content')
<div class="rb-card p-4">
    <form method="POST" action="{{ $rack->exists ? route('racks.update', $rack) : route('racks.store') }}">
        @csrf
        @if($rack->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Kode ID Rak</label>
                <input type="text" name="rack_code" value="{{ old('rack_code', $rack->rack_code) }}" class="form-control font-monospace" placeholder="RAK-04-K1" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Nomor Lemari</label>
                <input type="text" name="cabinet_number" value="{{ old('cabinet_number', $rack->cabinet_number) }}" class="form-control" placeholder="Lemari 4" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Nomor Kolom</label>
                <input type="text" name="column_number" value="{{ old('column_number', $rack->column_number) }}" class="form-control" placeholder="Kolom 1" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Kapasitas Maksimal (Kg)</label>
                <input type="number" step="0.5" name="max_capacity_kg" value="{{ old('max_capacity_kg', $rack->max_capacity_kg ?? 50) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Status Rak</label>
                <select name="status" class="form-select" required>
                    <option value="tersedia" @selected(old('status', $rack->status ?? 'tersedia') === 'tersedia')>Tersedia</option>
                    <option value="penuh" @selected(old('status', $rack->status) === 'penuh')>Penuh</option>
                    <option value="perbaikan" @selected(old('status', $rack->status) === 'perbaikan')>Perbaikan</option>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-semibold">Simpan</button>
            <a href="{{ route('racks.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
