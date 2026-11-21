@extends('layouts.app')

@section('title', 'Log Setrika & Rak')
@section('heading', 'Log Verifikasi Setrika & Serah Terima Rak')

@section('content')
<div class="rb-card p-3 mb-4">
    <h2 class="h6 fw-bold mb-3">Catat Rekap Setrika / Serah Terima</h2>
    <form method="POST" action="{{ route('logs.store') }}" class="row g-2 align-items-end">
        @csrf
        <div class="col-12 col-md-3">
            <label class="form-label small fw-semibold mb-1">Pilih Nota Cucian</label>
            <select name="laundry_storage_id" class="form-select form-select-sm" required>
                <option value="">-- Pilih Cucian --</option>
                @foreach($activeStorages as $st)
                    <option value="{{ $st->id }}">{{ $st->storage_code }} — {{ $st->customer_name }} ({{ $st->rack->rack_code }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">Nama Staf Setrika</label>
            <input type="text" name="ironer_name" class="form-control form-control-sm" placeholder="Contoh: Siti" required>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">Berat Verifikasi (Kg)</label>
            <input type="number" step="0.01" min="0.1" name="verified_weight" class="form-control form-control-sm" required>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">Aktivitas</label>
            <select name="action_type" class="form-select form-select-sm" required>
                <option value="masuk_rak">Masuk Rak</option>
                <option value="pindah_rak">Pindah Rak</option>
                <option value="serah_terima_ambil">Serah Terima Ambil</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">Catatan</label>
            <input type="text" name="notes" class="form-control form-control-sm" placeholder="Opsional">
        </div>
        <div class="col-12 col-md-1">
            <button type="submit" class="btn btn-primary btn-sm w-100">Catat</button>
        </div>
    </form>
</div>

<div class="rb-card p-3">
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Waktu</th>
                    <th>No. Nota</th>
                    <th>Pelanggan</th>
                    <th>Staf Setrika</th>
                    <th class="text-end">Berat</th>
                    <th>Aktivitas</th>
                    <th>Dicatat Oleh</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="small text-muted tnum">{{ $log->logged_at?->format('d/m/Y H:i') }}</td>
                        <td class="font-monospace small">{{ $log->storage->storage_code ?? '-' }}</td>
                        <td class="fw-semibold">{{ $log->storage->customer_name ?? '-' }}</td>
                        <td>{{ $log->ironer_name ?? '-' }}</td>
                        <td class="text-end tnum">{{ number_format($log->verified_weight, 2, ',', '.') }} Kg</td>
                        <td><span class="badge text-bg-light border text-dark">{{ str_replace('_', ' ', $log->action_type) }}</span></td>
                        <td class="small">{{ $log->handler->name ?? '-' }}</td>
                        <td class="small text-muted">{{ $log->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-3">Belum ada log aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $logs->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
