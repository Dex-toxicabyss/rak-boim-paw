@extends('layouts.app')

@section('title', 'Input Cucian')
@section('page_title', 'Input Cucian ke Rak')
@section('page_subtitle', 'Catat bundel cucian baru, pilih lokasi rak, dan hitung estimasi biaya otomatis')

@section('topbar_actions')
    <a href="{{ route('storages.index') }}" class="btn-secondary">Kembali ke Penataan Rak</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('storages.store') }}" class="checkout-form">
        @csrf
        @include('storages._form')
    </form>
@endsection