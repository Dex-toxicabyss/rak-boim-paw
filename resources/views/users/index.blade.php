@extends('layouts.app')

@section('title', 'Master User')
@section('heading', 'Master Akun Pengguna (Pemilik & Staf)')

@section('content')
<div class="rb-card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="small text-muted">Halaman ini hanya dapat diakses oleh peran Pemilik (dilindungi middleware).</div>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">+ Tambah Pengguna</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Peran</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td class="font-monospace small">{{ $user->email }}</td>
                        <td class="font-monospace small">{{ $user->phone ?? '-' }}</td>
                        <td><span class="badge {{ $user->isPemilik() ? 'text-bg-dark' : 'text-bg-primary' }}">{{ ucfirst($user->role) }}</span></td>
                        <td><span class="badge {{ $user->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
