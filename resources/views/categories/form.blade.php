@extends('layouts.app')

@section('title', $category->exists ? 'Edit Tarif' : 'Tambah Tarif')
@section('heading', $category->exists ? 'Edit Tarif Layanan' : 'Tambah Tarif Layanan Baru')

@section('content')
<div class="rb-card p-4">
    <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
        @csrf
        @if($category->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Kode Layanan</label>
                <input type="text" name="category_code" value="{{ old('category_code', $category->category_code) }}" class="form-control font-monospace" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Jenis Layanan</label>
                <select name="service_type" class="form-select" required>
                    <option value="kiloan_reguler" @selected(old('service_type', $category->service_type) === 'kiloan_reguler')>Kiloan Reguler</option>
                    <option value="kiloan_express" @selected(old('service_type', $category->service_type) === 'kiloan_express')>Kiloan Express</option>
                    <option value="satuan" @selected(old('service_type', $category->service_type) === 'satuan')>Satuan</option>
                    <option value="tambahan" @selected(old('service_type', $category->service_type) === 'tambahan')>Tambahan</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Satuan</label>
                <input type="text" name="unit_label" value="{{ old('unit_label', $category->unit_label ?? 'Kg') }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Nama Layanan</label>
                <input type="text" name="service_name" value="{{ old('service_name', $category->service_name) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-semibold">Tarif (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $category->price) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-semibold">Min. Berat</label>
                <input type="number" step="0.5" name="min_weight_kg" value="{{ old('min_weight_kg', $category->min_weight_kg ?? 2) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-semibold">Estimasi (Jam)</label>
                <input type="number" name="estimated_hours" value="{{ old('estimated_hours', $category->estimated_hours ?? 48) }}" class="form-control" required>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-semibold">Simpan</button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
