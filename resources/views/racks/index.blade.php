@extends('layouts.app')

@section('title', 'Master ID Rak')
@section('heading', 'Master ID Rak & Lemari Gudang')

@section('content')
<div class="rb-card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="small text-muted">Daftar sekat lemari penyimpanan gudang belakang Boim Laundry.</div>
        @if(auth()->user()->isPemilik())
            <a href="{{ route('racks.create') }}" class="btn btn-primary btn-sm">+ Tambah Rak</a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID Rak</th>
                    <th>Lemari</th>
                    <th>Kolom</th>
                    <th class="text-end">Bundel Aktif</th>
                    <th class="text-end">Beban Aktif</th>
                    <th class="text-end">Kapasitas Maks</th>
                    <th>Status</th>
                    @if(auth()->user()->isPemilik())
                        <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($racks as $rack)
                    <tr>
                        <td class="fw-semibold font-monospace">{{ $rack->rack_code }}</td>
                        <td>{{ $rack->cabinet_number }}</td>
                        <td>{{ $rack->column_number }}</td>
                        <td class="text-end tnum">{{ $rack->active_bundles_count }}</td>
                        <td class="text-end tnum">{{ number_format($rack->current_load_kg, 2, ',', '.') }} Kg</td>
                        <td class="text-end tnum">{{ number_format($rack->max_capacity_kg, 2, ',', '.') }} Kg</td>
                        <td>
                            <span class="badge {{ $rack->status === 'penuh' ? 'text-bg-danger' : ($rack->status === 'perbaikan' ? 'text-bg-secondary' : 'text-bg-success') }}">
                                {{ ucfirst($rack->status) }}
                            </span>
                        </td>
                        @if(auth()->user()->isPemilik())
                            <td class="text-end text-nowrap">
                                <a href="{{ route('racks.edit', $rack) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('racks.destroy', $rack) }}" class="d-inline" onsubmit="return confirm('Hapus rak {{ $rack->rack_code }}?')">
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
