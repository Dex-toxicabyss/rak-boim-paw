@extends('layouts.app')

@section('title', 'Input Cucian')
@section('heading', 'Input Transaksi & Penataan Rak Baru')

@section('content')
<div class="rb-card p-4">
    <form method="POST" action="{{ route('storages.store') }}">
        @csrf
        @include('storages._form')
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-semibold">Simpan ke Rak</button>
            <a href="{{ route('storages.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
