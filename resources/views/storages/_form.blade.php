@php
    $record = $laundryStorage ?? $storage ?? null;
    $isEdit = isset($record) && !empty($record->id);
    $categoriesList = $serviceCategories ?? $categories ?? [];
    $racksList = $racks ?? [];

    $selectedCategoryId = old('service_category_id', $record->service_category_id ?? '');
    $selectedRackId = old('rack_id', $record->rack_id ?? '');
    $selectedPayment = old('payment_status', $record->payment_status ?? 'belum_lunas');
    $selectedStatus = old('storage_status', $record->storage_status ?? 'tersimpan');
    $weightValue = old('laundry_weight', $record->laundry_weight ?? '2.00');
    $pickupChecked = old('is_pickup_delivery', $record->is_pickup_delivery ?? $record->pickup_delivery ?? false);
@endphp

@push('styles')
<style>
    /* Override aturan form global di app.blade.php agar layout 2 kolom tampil penuh */
    .content-wrap form.checkout-form {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
        max-width: none !important;
        display: grid !important;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 20px;
        align-items: start;
    }

    .checkout-main {
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-width: 0;
    }

    .form-section-card {
        background: var(--bg-ground);
        border: 1px solid var(--border-hairline);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .form-section-head {
        padding: 13px 18px;
        border-bottom: 1px solid var(--border-light);
        background: var(--bg-subtle);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .step-badge {
        width: 22px;
        height: 22px;
        border-radius: 999px;
        background: var(--accent-soft);
        color: var(--accent);
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .form-section-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--ink-primary);
        letter-spacing: -0.01em;
    }

    .form-section-sub {
        font-size: 11.5px;
        color: var(--ink-muted);
        margin-left: auto;
    }

    .form-section-body {
        padding: 18px;
    }

    .field-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px 16px;
    }

    .field-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 0 !important;
    }

    .field-group.is-full {
        grid-column: 1 / -1;
    }

    .field-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--ink-secondary);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .field-hint {
        font-size: 11px;
        font-weight: 400;
        color: var(--ink-muted);
    }

    .field-error {
        font-size: 11.5px;
        color: var(--red-ink);
        margin-top: 4px;
    }

    /* Toggle Card Jemput-Antar */
    .addon-toggle {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-hairline);
        background: var(--bg-subtle);
        cursor: pointer;
        margin-top: 14px;
        margin-bottom: 14px !important;
        transition: border-color 150ms var(--ease-out), background-color 150ms var(--ease-out);
    }

    .addon-toggle:hover {
        border-color: #B8B8BE;
        background: var(--bg-surface);
    }

    .addon-toggle.is-checked {
        border-color: var(--accent);
        background: var(--accent-soft);
    }

    .addon-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .addon-left input[type="checkbox"] {
        width: 16px !important;
        height: 16px !important;
        margin: 0 !important;
        cursor: pointer;
        flex-shrink: 0;
    }

    .addon-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--ink-primary);
    }

    .addon-sub {
        font-size: 11.5px;
        color: var(--ink-muted);
        margin-top: 1px;
    }

    .addon-price {
        font-size: 12px;
        font-weight: 700;
        color: var(--accent);
        background: var(--bg-ground);
        border: 1px solid var(--border-light);
        padding: 4px 9px;
        border-radius: 999px;
        white-space: nowrap;
    }

    /* Kolom Kanan: Sticky Ringkasan Nota */
    .summary-sidebar {
        position: sticky;
        top: 76px;
        background: var(--bg-ground);
        border: 1px solid var(--border-hairline);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .summary-head {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--bg-subtle);
    }

    .summary-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--ink-primary);
    }

    .summary-pill {
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 999px;
        background: var(--accent-soft);
        color: var(--accent);
    }

    .summary-body {
        padding: 16px 18px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        font-size: 12.5px;
        padding: 6px 0;
    }

    .summary-key {
        color: var(--ink-muted);
    }

    .summary-val {
        color: var(--ink-primary);
        font-weight: 600;
        text-align: right;
    }

    .summary-divider {
        height: 1px;
        background: var(--border-light);
        margin: 12px 0;
    }

    .summary-total-box {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 16px;
    }

    .summary-total-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--ink-secondary);
    }

    .summary-total-amount {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--ink-primary);
    }

    .summary-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .summary-actions button[type="submit"],
    .summary-actions a {
        width: 100%;
        margin-left: 0 !important;
        height: 40px;
    }

    .summary-footnote {
        font-size: 11px;
        color: var(--ink-muted);
        margin-top: 12px;
        line-height: 1.45;
    }

    @media (max-width: 1024px) {
        .content-wrap form.checkout-form {
            grid-template-columns: 1fr;
        }

        .summary-sidebar {
            position: static;
        }
    }

    @media (max-width: 640px) {
        .field-grid-2 {
            grid-template-columns: 1fr;
        }

        .form-section-sub {
            display: none;
        }
    }
</style>
@endpush

<div class="checkout-main">
    {{-- Bagian 1: Data Pelanggan --}}
    <section class="form-section-card">
        <div class="form-section-head">
            <span class="step-badge mono">1</span>
            <div class="form-section-title">Data Pelanggan</div>
            <span class="form-section-sub">4 digit terakhir dipakai untuk pencarian cepat</span>
        </div>
        <div class="form-section-body">
            <div class="field-grid-2">
                <div class="field-group">
                    <label for="customer_name" class="field-label">
                        <span>Nama Pelanggan</span>
                    </label>
                    <input
                        id="customer_name"
                        type="text"
                        name="customer_name"
                        value="{{ old('customer_name', $record->customer_name ?? '') }}"
                        placeholder="Contoh: Budi Santoso"
                        required
                    >
                    @error('customer_name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label for="customer_phone" class="field-label">
                        <span>Nomor Telepon</span>
                        <span class="field-hint">10–15 digit angka</span>
                    </label>
                    <input
                        id="customer_phone"
                        type="text"
                        name="customer_phone"
                        value="{{ old('customer_phone', $record->customer_phone ?? '') }}"
                        placeholder="081298765459"
                        class="mono"
                        required
                    >
                    @error('customer_phone')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian 2: Detail Cucian & Lokasi Rak --}}
    <section class="form-section-card">
        <div class="form-section-head">
            <span class="step-badge mono">2</span>
            <div class="form-section-title">Detail Cucian &amp; Penempatan Rak</div>
            <span class="form-section-sub">Beban rak dihitung otomatis</span>
        </div>
        <div class="form-section-body">
            <div class="field-grid-2">
                <div class="field-group">
                    <label for="service_category_id" class="field-label">
                        <span>Paket Layanan Boim Laundry</span>
                    </label>
                    <select id="service_category_id" name="service_category_id" required>
                        <option value="" data-price="0" data-unit="Kg" data-min="1">-- Pilih Paket Layanan --</option>
                        @foreach($categoriesList as $cat)
                            @php
                                $priceVal = $cat->price_per_unit ?? $cat->price ?? 0;
                                $unitVal = $cat->unit_label ?? 'Kg';
                                $minVal = $cat->min_weight ?? 1;
                            @endphp
                            <option
                                value="{{ $cat->id }}"
                                data-name="{{ $cat->service_name }}"
                                data-price="{{ $priceVal }}"
                                data-unit="{{ $unitVal }}"
                                data-min="{{ $minVal }}"
                                {{ (string)$selectedCategoryId === (string)$cat->id ? 'selected' : '' }}
                            >
                                {{ $cat->service_name }} — Rp {{ number_format((float)$priceVal, 0, ',', '.') }}/{{ $unitVal }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_category_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label for="laundry_weight" class="field-label">
                        <span>Berat (Kg) / Jumlah</span>
                        <span class="field-hint" id="weight-unit-hint">Satuan: Kg</span>
                    </label>
                    <input
                        id="laundry_weight"
                        type="number"
                        step="0.01"
                        min="0.1"
                        name="laundry_weight"
                        value="{{ $weightValue }}"
                        class="mono"
                        required
                    >
                    @error('laundry_weight')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label for="rack_id" class="field-label">
                        <span>Lokasi ID Rak</span>
                    </label>
                    <select id="rack_id" name="rack_id" required>
                        <option value="" data-code="-">-- Pilih Rak --</option>
                        @foreach($racksList as $rack)
                            @php
                                $sisa = max(0, (float)$rack->max_capacity_kg - (float)$rack->current_load_kg);
                            @endphp
                            <option
                                value="{{ $rack->id }}"
                                data-code="{{ $rack->rack_code }}"
                                {{ (string)$selectedRackId === (string)$rack->id ? 'selected' : '' }}
                            >
                                {{ $rack->rack_code }} — Lemari {{ $rack->cabinet_number }} Kolom {{ $rack->column_number }} (Sisa {{ number_format($sisa, 1, ',', '.') }} Kg)
                            </option>
                        @endforeach
                    </select>
                    @error('rack_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label for="ironing_staff_name" class="field-label">
                        <span>Nama Staf Setrika</span>
                        <span class="field-hint">Opsional</span>
                    </label>
                    <input
                        id="ironing_staff_name"
                        type="text"
                        name="ironing_staff_name"
                        value="{{ old('ironing_staff_name', $record->ironing_staff_name ?? '') }}"
                        placeholder="Contoh: Siti (untuk log verifikasi)"
                    >
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian 3: Status, Jemput-Antar & Catatan --}}
    <section class="form-section-card">
        <div class="form-section-head">
            <span class="step-badge mono">3</span>
            <div class="form-section-title">Status, Opsi &amp; Catatan</div>
            <span class="form-section-sub">Pembayaran dan kondisi bundel</span>
        </div>
        <div class="form-section-body">
            <div class="field-grid-2">
                <div class="field-group">
                    <label for="payment_status" class="field-label">
                        <span>Status Pembayaran</span>
                    </label>
                    <select id="payment_status" name="payment_status">
                        <option value="belum_lunas" {{ $selectedPayment === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="lunas" {{ $selectedPayment === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>

                <div class="field-group">
                    <label for="storage_status" class="field-label">
                        <span>Status Penyimpanan Rak</span>
                    </label>
                    <select id="storage_status" name="storage_status">
                        <option value="tersimpan" {{ $selectedStatus === 'tersimpan' ? 'selected' : '' }}>Tersimpan di Rak</option>
                        <option value="siap_diambil" {{ $selectedStatus === 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
                        <option value="selesai" {{ $selectedStatus === 'selesai' ? 'selected' : '' }}>Selesai (Sudah Diambil)</option>
                    </select>
                </div>
            </div>

            <label class="addon-toggle {{ $pickupChecked ? 'is-checked' : '' }}" id="pickup-toggle-card" for="is_pickup_delivery">
                <div class="addon-left">
                    <input
                        id="is_pickup_delivery"
                        type="checkbox"
                        name="is_pickup_delivery"
                        value="1"
                        {{ $pickupChecked ? 'checked' : '' }}
                    >
                    <div>
                        <div class="addon-title">Tambahkan Layanan Jemput-Antar (PP)</div>
                        <div class="addon-sub">Biaya tetap antar-jemput langsung ke alamat pelanggan</div>
                    </div>
                </div>
                <span class="addon-price mono">+Rp 10.000</span>
            </label>

            <div class="field-group is-full">
                <label for="notes" class="field-label">
                    <span>Catatan Tambahan</span>
                    <span class="field-hint">Opsional</span>
                </label>
                <textarea
                    id="notes"
                    name="notes"
                    placeholder="Contoh: Plastik biru muda, ada selimut tambahan, atau keterangan pindah rak"
                >{{ old('notes', $record->notes ?? '') }}</textarea>
            </div>
        </div>
    </section>
</div>

{{-- Kolom Kanan: Sticky Ringkasan Nota --}}
<aside class="summary-sidebar">
    <div class="summary-head">
        <span class="summary-title">Ringkasan Nota</span>
        <span class="summary-pill">{{ $isEdit ? 'Mode Edit' : 'Nota Baru' }}</span>
    </div>

    <div class="summary-body">
        <div class="summary-row">
            <span class="summary-key">Paket</span>
            <span class="summary-val" id="sum-service">Belum dipilih</span>
        </div>
        <div class="summary-row">
            <span class="summary-key">Tarif Satuan</span>
            <span class="summary-val mono" id="sum-rate">Rp 0</span>
        </div>
        <div class="summary-row">
            <span class="summary-key">Berat / Qty</span>
            <span class="summary-val mono" id="sum-weight">2,00 Kg</span>
        </div>
        <div class="summary-row">
            <span class="summary-key">Lokasi Rak</span>
            <span class="summary-val mono" id="sum-rack">-</span>
        </div>
        <div class="summary-row">
            <span class="summary-key">Jemput-Antar (PP)</span>
            <span class="summary-val mono" id="sum-delivery">Rp 0</span>
        </div>

        <div class="summary-divider"></div>

        <div class="summary-total-box">
            <span class="summary-total-label">Estimasi Total</span>
            <span class="summary-total-amount mono" id="sum-total">Rp 0</span>
        </div>

        <div class="summary-actions">
            <button type="submit" class="btn-primary">
                {{ $isEdit ? 'Simpan Perubahan' : 'Simpan ke Rak' }}
            </button>
            <a href="{{ route('storages.index') }}" class="btn-secondary">Batal</a>
        </div>

        <p class="summary-footnote">
            Total akhir divalidasi ulang otomatis oleh sistem berdasarkan tarif aktif dan berat/jumlah aktual.
        </p>
    </div>
</aside>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const serviceEl = document.getElementById('service_category_id');
    const weightEl = document.getElementById('laundry_weight');
    const rackEl = document.getElementById('rack_id');
    const pickupEl = document.getElementById('is_pickup_delivery');
    const pickupCard = document.getElementById('pickup-toggle-card');

    const sumService = document.getElementById('sum-service');
    const sumRate = document.getElementById('sum-rate');
    const sumWeight = document.getElementById('sum-weight');
    const sumRack = document.getElementById('sum-rack');
    const sumDelivery = document.getElementById('sum-delivery');
    const sumTotal = document.getElementById('sum-total');
    const unitHint = document.getElementById('weight-unit-hint');

    const formatRupiah = (num) => 'Rp ' + Math.round(num).toLocaleString('id-ID');

    function recalc() {
        const opt = serviceEl && serviceEl.selectedOptions[0];
        const price = opt ? parseFloat(opt.dataset.price || 0) : 0;
        const unit = opt ? (opt.dataset.unit || 'Kg') : 'Kg';
        const serviceName = opt && opt.value ? (opt.dataset.name || opt.textContent.trim()) : 'Belum dipilih';

        const weight = Math.max(0, parseFloat(weightEl ? weightEl.value : 0) || 0);
        const deliveryFee = pickupEl && pickupEl.checked ? 10000 : 0;
        const total = (price * weight) + deliveryFee;

        const rackOpt = rackEl && rackEl.selectedOptions[0];
        const rackCode = rackOpt && rackOpt.value ? (rackOpt.dataset.code || rackOpt.textContent.trim()) : '-';

        if (pickupCard && pickupEl) {
            pickupCard.classList.toggle('is-checked', pickupEl.checked);
        }

        if (unitHint) unitHint.textContent = 'Satuan: ' + unit;
        if (sumService) sumService.textContent = serviceName;
        if (sumRate) sumRate.textContent = price > 0 ? formatRupiah(price) + '/' + unit : 'Rp 0';
        if (sumWeight) sumWeight.textContent = weight.toFixed(2).replace('.', ',') + ' ' + unit;
        if (sumRack) sumRack.textContent = rackCode;
        if (sumDelivery) sumDelivery.textContent = formatRupiah(deliveryFee);
        if (sumTotal) sumTotal.textContent = formatRupiah(total);
    }

    [serviceEl, weightEl, rackEl, pickupEl].forEach((el) => {
        if (!el) return;
        el.addEventListener('change', recalc);
        el.addEventListener('input', recalc);
    });

    recalc();
});
</script>
@endpush