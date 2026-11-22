@extends('layouts.app')

@section('title', 'Kelola Cucian')
@section('page_title', 'Kelola Cucian & Serah Terima')
@section('page_subtitle', 'Perbarui lokasi rak, status pembayaran, atau selesaikan serah terima pelanggan')

@section('topbar_actions')
    <a href="{{ route('storages.index') }}" class="btn-secondary">Kembali ke Penataan Rak</a>
@endsection

@section('content')
    @php
        $target = $laundryStorage ?? $storage;
    @endphp
    <form method="POST" action="{{ route('storages.update', $target) }}" class="checkout-form">
        @csrf
        @method('PUT')
        @include('storages._form')
    </form>
@endsection