@extends('layouts.app')

@section('title', 'Penataan Rak — Rak Boim')
@section('page_title', 'Penataan Rak')

@push('styles')
<style>
  .storage-workspace-grid {
    display: grid;
    grid-template-columns: 256px minmax(0, 1fr);
    gap: 20px;
    align-items: start;
  }

  .filter-sidebar-card {
    background: #FFFFFF;
    border: 1px solid var(--border-hairline);
    border-radius: var(--radius-card);
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    position: sticky;
    top: 76px;
  }

  .filter-block-title {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--ink-primary);
    margin-bottom: 6px;
  }

  .pill-bar-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 16px;
  }

  .pill-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .pill-link {
    padding: 7px 14px;
    border-radius: var(--radius-md);
    background: var(--bg-surface);
    font-size: 13px;
    font-weight: 600;
    color: var(--ink-secondary);
    transition: all var(--dur-fast) var(--ease-apple);
  }

  .pill-link:hover {
    background: var(--bg-surface-hover);
    color: var(--ink-primary);
  }

  .pill-link.active {
    background: var(--ink-primary);
    color: #FFFFFF;
  }

  .cards-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
  }

  .laundry-card {
    background: #FFFFFF;
    border: 1px solid var(--border-hairline);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform var(--dur-fast) var(--ease-apple), box-shadow var(--dur-fast) var(--ease-apple), border-color var(--dur-fast) var(--ease-apple);
  }

  .laundry-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-card-hover);
    border-color: #B8B8C0;
  }

  .card-head {
    background: var(--bg-surface);
    padding: 11px 14px;
    border-bottom: 1px solid var(--border-subtle);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 6px;
  }

  .card-body {
    padding: 14px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .customer-name {
    font-size: 15px;
    font-weight: 700;
    color: var(--ink-primary);
    letter-spacing: -0.015em;
  }

  .phone-last4 {
    color: var(--ink-primary);
    font-weight: 700;
    background: var(--bg-surface);
    border: 1px solid var(--border-hairline);
    padding: 1px 5px;
    border-radius: 5px;
  }

  .card-foot {
    border-top: 1px solid #ECECEF;
    padding: 11px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    background: #FFFFFF;
  }

  @media (max-width: 1280px) {
    .cards-grid-3 {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 900px) {
    .storage-workspace-grid {
      grid-template-columns: 1fr;
    }
    .filter-sidebar-card {
      position: static;
    }
    .cards-grid-3 {
      grid-template-columns: 1fr;
    }
  }
</style>
@endpush

@section('content')
  <!-- Operational Summary Banner -->
  <section class="summary-banner">
    <div>
      <h1>Penataan Penyimpanan Cucian Rak</h1>
      <p>Pantau slot rak aktif, verifikasi 4 digit terakhir nomor telepon pelanggan, dan perbarui status serah terima.</p>
    </div>
    <a href="{{ route('laundry-storages.create') }}" class="btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      <span>Input Cucian Baru</span>
    </a>
  </section>

  <!-- 2-Column Content: Filter Sidebar (256px) + Cards Grid -->
  <div class="storage-workspace-grid">
    <!-- Filter Panel -->
    <aside class="filter-sidebar-card">
      <form method="GET" action="{{ route('laundry-storages.index') }}" style="display:flex; flex-direction:column; gap:14px;">
        <div>
          <div class="filter-block-title">Cari Nota / 4 Digit Telp</div>
          <input
            type="text"
            name="search"
            id="quickSearchInput"
            value="{{ request('search') }}"
            class="form-input"
            placeholder="Nama, 4 digit telp, nota..."
          >
        </div>

        <div>
          <div class="filter-block-title">Filter ID Rak</div>
          <select name="rack_id" class="form-select mono" style="font-size:12.5px;">
            <option value="">Semua Rak (6 Slot)</option>
            @foreach($racks ?? [] as $rack)
              <option value="{{ $rack->id }}" {{ (string) request('rack_id') === (string) $rack->id ? 'selected' : '' }}>
                {{ $rack->rack_code }} ({{ number_format($rack->current_load_kg, 1) }}/{{ number_format($rack->max_capacity_kg, 0) }} kg)
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <div class="filter-block-title">Status Penyimpanan</div>
          <select name="storage_status" class="form-select">
            <option value="">Semua Status</option>
            <option value="tersimpan" {{ request('storage_status') === 'tersimpan' ? 'selected' : '' }}>Tersimpan</option>
            <option value="siap_diambil" {{ request('storage_status') === 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
            <option value="selesai" {{ request('storage_status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
          </select>
        </div>

        <div>
          <div class="filter-block-title">Status Pembayaran</div>
          <select name="payment_status" class="form-select">
            <option value="">Semua Pembayaran</option>
            <option value="lunas" {{ request('payment_status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
            <option value="belum_lunas" {{ request('payment_status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
          </select>
        </div>

        <div>
          <div class="filter-block-title">Urutkan</div>
          <select name="sort" class="form-select">
            <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Terbaru Masuk</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama di Rak</option>
            <option value="weight_desc" {{ request('sort') === 'weight_desc' ? 'selected' : '' }}>Berat Terbesar</option>
            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama Pelanggan A–Z</option>
          </select>
        </div>

        <div style="display:flex; flex-direction:column; gap:6px; padding-top:4px;">
          <button type="submit" class="btn-primary full">Terapkan Filter</button>
          @if(request()->hasAny(['search', 'rack_id', 'storage_status', 'payment_status', 'sort']))
            <a href="{{ route('laundry-storages.index') }}" class="btn-secondary" style="width:100%; justify-content:center;">Reset Filter</a>
          @endif
        </div>
      </form>
    </aside>

    <!-- Main Cards Grid -->
    <div>
      <!-- Quick Status Pill Bar -->
      <div class="pill-bar-row">
        <div class="pill-group">
          <a href="{{ route('laundry-storages.index') }}" class="pill-link {{ !request('storage_status') ? 'active' : '' }}">Semua</a>
          <a href="{{ route('laundry-storages.index', ['storage_status' => 'tersimpan']) }}" class="pill-link {{ request('storage_status') === 'tersimpan' ? 'active' : '' }}">Tersimpan</a>
          <a href="{{ route('laundry-storages.index', ['storage_status' => 'siap_diambil']) }}" class="pill-link {{ request('storage_status') === 'siap_diambil' ? 'active' : '' }}">Siap Diambil</a>
          <a href="{{ route('laundry-storages.index', ['storage_status' => 'selesai']) }}" class="pill-link {{ request('storage_status') === 'selesai' ? 'active' : '' }}">Selesai</a>
        </div>
        <span class="mono" style="font-size:12px; color:var(--ink-muted);">
          Total: {{ method_exists($storages, 'total') ? $storages->total() : $storages->count() }} nota
        </span>
      </div>

      @if($storages->isEmpty())
        <div class="apple-card" style="padding:44px 20px; text-align:center; color:var(--ink-muted);">
          <div style="font-weight:700; color:var(--ink-primary); margin-bottom:4px;">Belum ada data cucian pada filter ini</div>
          <div style="font-size:13px; margin-bottom:14px;">Tambahkan transaksi penataan rak baru atau reset filter pencarian.</div>
          <a href="{{ route('laundry-storages.create') }}" class="btn-primary">+ Input Cucian Baru</a>
        </div>
      @else
        <div class="cards-grid-3">
          @foreach($storages as $storage)
            @php
              $digits = preg_replace('/\D/', '', $storage->customer_phone);
              $last4 = strlen($digits) >= 4 ? substr($digits, -4) : $digits;
              $prefix = strlen($digits) > 4 ? substr($digits, 0, -4) : '';
              $isExpress = optional($storage->serviceCategory)->service_type === 'kiloan_express';
            @endphp
            <article class="laundry-card">
              <div class="card-head">
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                  <span class="rack-pill">{{ optional($storage->rack)->rack_code ?? '-' }}</span>
                  <span class="status-pill status-{{ $storage->storage_status }}">
                    {{ ucwords(str_replace('_', ' ', $storage->storage_status)) }}
                  </span>
                </div>
                <span class="mono" style="font-size:11px; color:var(--ink-muted);">{{ $storage->storage_code }}</span>
              </div>

              <div class="card-body">
                <div class="customer-name">{{ $storage->customer_name }}</div>

                <div class="mono" style="font-size:12.5px; color:var(--ink-muted);">
                  {{ $prefix }}<span class="phone-last4">{{ $last4 }}</span>
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between; font-size:12.5px; font-weight:600; color:var(--ink-secondary);">
                  <span>{{ optional($storage->serviceCategory)->service_name ?? 'Layanan Laundry' }}</span>
                  <span class="mono" style="color:var(--ink-primary);">
                    {{ number_format($storage->laundry_weight, 1) }} {{ optional($storage->serviceCategory)->unit_label ?? 'kg' }}
                  </span>
                </div>

                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-top:2px;">
                  @if($isExpress)
                    <span style="font-size:11px; font-weight:600; padding:2px 7px; border-radius:6px; background:var(--status-amber-bg); color:var(--status-amber);">Express</span>
                  @endif
                  @if($storage->include_delivery)
                    <span style="font-size:11px; font-weight:600; padding:2px 7px; border-radius:6px; background:var(--accent-soft); color:var(--accent);">Antar-Jemput PP</span>
                  @endif
                  <span style="font-size:11px; color:var(--ink-muted);">
                    {{ \Carbon\Carbon::parse($storage->stored_at)->format('d M, H:i') }}
                  </span>
                </div>
              </div>

              <div class="card-foot">
                <div>
                  <div class="mono" style="font-size:14.5px; font-weight:700; color:var(--ink-primary);">
                    Rp {{ number_format($storage->total_price, 0, ',', '.') }}
                  </div>
                  <div style="display:inline-flex; align-items:center; gap:5px; font-size:11.5px; font-weight:600; color:{{ $storage->payment_status === 'lunas' ? 'var(--status-green)' : 'var(--status-amber)' }};">
                    <span class="dot {{ $storage->payment_status === 'lunas' ? 'dot-green' : 'dot-amber' }}"></span>
                    <span>{{ $storage->payment_status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}</span>
                  </div>
                </div>

                <div style="display:flex; align-items:center; gap:6px;">
                  <a href="{{ route('laundry-storages.edit', $storage->id) }}" class="btn-secondary" style="padding:6px 10px; font-size:12px;">
                    Edit / Rak
                  </a>

                  @if(auth()->check() && auth()->user()->isPemilik() && $storage->storage_status === 'selesai')
                    <form action="{{ route('laundry-storages.destroy', $storage->id) }}" method="POST" onsubmit="return true;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-danger" style="padding:6px 9px; font-size:12px;">Hapus</button>
                    </form>
                  @endif
                </div>
              </div>
            </article>
          @endforeach
        </div>

        @if(method_exists($storages, 'links'))
          <div style="margin-top:18px;">
            {{ $storages->withQueryString()->links() }}
          </div>
        @endif
      @endif
    </div>
  </div>
@endsection

@push('scripts')
<script>
  // Shortcut "/" langsung fokus ke kotak pencarian 4 digit telepon
  document.addEventListener('keydown', function (e) {
    const tag = document.activeElement.tagName;
    if (e.key === '/' && tag !== 'INPUT' && tag !== 'TEXTAREA' && tag !== 'SELECT') {
      e.preventDefault();
      const searchBox = document.getElementById('quickSearchInput');
      if (searchBox) searchBox.focus();
    }
  });
</script>
@endpush