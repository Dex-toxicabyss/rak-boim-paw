@extends('layouts.app')

@section('title', 'Master Tarif')
@section('heading', 'Master Tarif Layanan Boim Laundry')

@section('content')
<div class="rb-card p-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="btn-group btn-group-sm">
            <a href="{{ route('categories.index') }}" class="btn {{ !$type ? 'btn-dark' : 'btn-outline-secondary' }}">Semua</a>
            <a href="{{ route('categories.index', ['type' => 'kiloan_reguler']) }}" class="btn {{ $type === 'kiloan_reguler' ? 'btn-dark' : 'btn-outline-secondary' }}">Kiloan Reguler</a>
            <a href="{{ route('categories.index', ['type' => 'kiloan_express']) }}" class="btn {{ $type === 'kiloan_express' ? 'btn-dark' : 'btn-outline-secondary' }}">Express</a>
            <a href="{{ route('categories.index', ['type' => 'satuan']) }}" class="btn {{ $type === 'satuan' ? 'btn-dark' : 'btn-outline-secondary' }}">Satuan (23 Item)</a>
        </div>
        @if(auth()->user()->isPemilik())
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">+ Tambah Tarif</a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Layanan</th>
                    <th>Jenis</th>
                    <th class="text-end">Tarif</th>
                    <th class="text-end">Min. Berat</th>
                    <th class="text-end">Estimasi</th>
                    @if(auth()->user()->isPemilik())
                        <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr>
                        <td class="font-monospace small">{{ $cat->category_code }}</td>
                        <td class="fw-semibold">{{ $cat->service_name }}</td>
                        <td><span class="badge text-bg-light border text-dark">{{ str_replace('_', ' ', $cat->service_type) }}</span></td>
                        <td class="text-end tnum fw-semibold">Rp {{ number_format($cat->price, 0, ',', '.') }} / {{ $cat->unit_label }}</td>
                        <td class="text-end tnum">{{ (float) $cat->min_weight_kg }} {{ $cat->unit_label }}</td>
                        <td class="text-end tnum">{{ $cat->estimated_hours }} Jam</td>
                        @if(auth()->user()->isPemilik())
                            <td class="text-end text-nowrap">
                                <a href="{{ route('categories.edit', $cat) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $cat) }}" class="d-inline" onsubmit="return confirm('Hapus tarif layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
