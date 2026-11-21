@extends('layouts.app')

@section('title', 'Edit Cucian')
@section('heading', 'Edit Penataan Rak — ' . $laundryStorage->storage_code)

@section('content')
<div class="rb-card p-4">
    <form method="POST" action="{{ route('storages.update', $laundryStorage) }}">
        @csrf
        @method('PUT')
        @include('storages._form', ['laundryStorage' => $laundryStorage])
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-semibold">Perbarui Data</button>
            <a href="{{ route('storages.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
