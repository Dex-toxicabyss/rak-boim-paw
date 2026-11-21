@extends('layouts.app')

@section('title', $user->exists ? 'Edit User' : 'Tambah User')
@section('heading', $user->exists ? 'Edit Akun Pengguna' : 'Tambah Akun Pengguna Baru')

@section('content')
<div class="rb-card p-4">
    <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}">
        @csrf
        @if($user->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control font-monospace">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Peran Pengguna</label>
                <select name="role" class="form-select" required>
                    <option value="staf" @selected(old('role', $user->role) === 'staf')>Staf</option>
                    <option value="pemilik" @selected(old('role', $user->role) === 'pemilik')>Pemilik</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Password {{ $user->exists ? '(Kosongkan jika tetap)' : '' }}</label>
                <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" @checked(old('is_active', $user->is_active ?? true))>
                    <label for="is_active" class="form-check-label">Akun Aktif</label>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-semibold">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
