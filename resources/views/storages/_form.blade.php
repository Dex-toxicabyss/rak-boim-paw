@php
    $storage = $laundryStorage ?? null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label class="form-label fw-semibold">Nama Pelanggan</label>
        <input type="text" name="customer_name" value="{{ old('customer_name', $storage->customer_name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label fw-semibold">Nomor Telepon (10–15 digit angka)</label>
        <input type="text" name="customer_phone" value="{{ old('customer_phone', $storage->customer_phone ?? '') }}" class="form-control font-monospace" placeholder="081298765459" required>
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label fw-semibold">Paket Layanan Boim Laundry</label>
        <select name="service_category_id" id="service_category_id" class="form-select" required>
            <option value="">-- Pilih Paket Layanan --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                        data-price="{{ $cat->price }}"
                        data-min="{{ $cat->min_weight_kg }}"
                        data-type="{{ $cat->service_type }}"
                        @selected(old('service_category_id', $storage->service_category_id ?? '') == $cat->id)>
                    {{ $cat->service_name }} — Rp {{ number_format($cat->price, 0, ',', '.') }}/{{ $cat->unit_label }}
                    @if($cat->isKiloan()) (Min. {{ (float) $cat->min_weight_kg }} kg) @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-md-3">
        <label class="form-label fw-semibold">Berat (Kg) / Jumlah</label>
        <input type="number" step="0.01" min="0.1" name="laundry_weight" id="laundry_weight" value="{{ old('laundry_weight', $storage->laundry_weight ?? '2.00') }}" class="form-control tnum" required>
    </div>

    <div class="col-12 col-md-3">
        <label class="form-label fw-semibold">Lokasi ID Rak</label>
        <select name="rack_id" class="form-select font-monospace" required>
            <option value="">-- Pilih Rak --</option>
            @foreach($racks as $rack)
                <option value="{{ $rack->id }}" @selected(old('rack_id', $storage->rack_id ?? '') == $rack->id)>
                    {{ $rack->rack_code }} ({{ number_format($rack->current_load_kg, 1) }}/{{ number_format($rack->max_capacity_kg, 0) }} kg)
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label fw-semibold">Status Pembayaran</label>
        <select name="payment_status" class="form-select" required>
            <option value="belum_lunas" @selected(old('payment_status', $storage->payment_status ?? 'belum_lunas') === 'belum_lunas')>Belum Lunas</option>
            <option value="lunas" @selected(old('payment_status', $storage->payment_status ?? '') === 'lunas')>Lunas</option>
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label fw-semibold">Status Penyimpanan Rak</label>
        <select name="storage_status" class="form-select" required>
            <option value="tersimpan" @selected(old('storage_status', $storage->storage_status ?? 'tersimpan') === 'tersimpan')>Tersimpan di Rak</option>
            <option value="siap_diambil" @selected(old('storage_status', $storage->storage_status ?? '') === 'siap_diambil')>Siap Diambil</option>
            <option value="selesai" @selected(old('storage_status', $storage->storage_status ?? '') === 'selesai')>Selesai (Sudah Diambil)</option>
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label fw-semibold">Nama Staf Setrika (Opsional)</label>
        <input type="text" name="ironer_name" value="{{ old('ironer_name') }}" class="form-control" placeholder="Untuk log verifikasi setrika">
    </div>

    <div class="col-12 col-md-6">
        <div class="form-check mt-2">
            <input type="checkbox" name="include_delivery" id="include_delivery" value="1" class="form-check-input" @checked(old('include_delivery', $storage->include_delivery ?? false))>
            <label for="include_delivery" class="form-check-label fw-semibold">Tambahkan Layanan Jemput-Antar (PP) +Rp 10.000</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="p-3 bg-light border rounded d-flex justify-content-between align-items-center">
            <span class="small text-muted fw-semibold">Estimasi Total Biaya Otomatis:</span>
            <span id="pricePreview" class="h5 mb-0 fw-bold text-primary tnum">Rp 0</span>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Catatan Tambahan (Opsional)</label>
        <textarea name="notes" rows="2" class="form-control" placeholder="Catatan warna plastik atau keterangan pindah rak">{{ old('notes') }}</textarea>
    </div>
</div>

@push('scripts')
<script>
    function updatePricePreview() {
        const select = document.getElementById('service_category_id');
        const weightInput = document.getElementById('laundry_weight');
        const deliveryCheck = document.getElementById('include_delivery');
        const output = document.getElementById('pricePreview');

        const opt = select.options[select.selectedIndex];
        if (!opt || !opt.value) {
            output.textContent = 'Rp 0';
            return;
        }
        const price = parseFloat(opt.dataset.price || 0);
        const minW = parseFloat(opt.dataset.min || 0);
        const type = opt.dataset.type || '';
        const rawWeight = parseFloat(weightInput.value || 0);
        const isKiloan = type === 'kiloan_reguler' || type === 'kiloan_express';
        const effective = isKiloan ? Math.max(rawWeight, minW) : rawWeight;
        const delivery = deliveryCheck.checked ? 10000 : 0;
        const total = Math.round(effective * price + delivery);

        output.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.getElementById('service_category_id').addEventListener('change', updatePricePreview);
    document.getElementById('laundry_weight').addEventListener('input', updatePricePreview);
    document.getElementById('include_delivery').addEventListener('change', updatePricePreview);
    updatePricePreview();
</script>
@endpush
