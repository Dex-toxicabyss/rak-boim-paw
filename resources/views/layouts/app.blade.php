<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rak Boim') — Boim Laundry</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-ground: #FFFFFF;
            --bg-surface: #F5F5F7;
            --bg-subtle: #FAFAFC;
            --bg-hover: #ECECEF;
            --border-hairline: #D2D2D7;
            --border-light: #E5E5EA;
            --ink-primary: #1D1D1F;
            --ink-secondary: #424245;
            --ink-muted: #86868B;
            --accent: #0071E3;
            --accent-hover: #0062C4;
            --accent-soft: color-mix(in srgb, var(--accent) 10%, transparent);
            --green-ink: #248A3D;
            --green-bg: rgba(36, 138, 61, 0.10);
            --amber-ink: #B25000;
            --amber-bg: rgba(178, 80, 0, 0.10);
            --red-ink: #D70015;
            --red-bg: rgba(215, 0, 21, 0.10);
            --font-sans: "Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, "SF Pro Text", "Segoe UI", sans-serif;
            --font-mono: "JetBrains Mono", ui-monospace, SFMono-Regular, Menlo, monospace;
            --radius-sm: 8px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --shadow-card: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 6px 20px rgba(0, 0, 0, 0.06);
            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg-ground);
            color: var(--ink-primary);
            font-size: 14px;
            line-height: 1.45;
            -webkit-font-smoothing: antialiased;
            text-wrap: pretty;
        }

        .mono {
            font-family: var(--font-mono);
            font-variant-numeric: tabular-nums;
        }

        .app-shell {
            display: grid;
            grid-template-columns: 236px minmax(0, 1fr);
            min-height: 100vh;
            background: var(--bg-ground);
        }

        /* Sidebar */
        .sidebar {
            background: var(--bg-surface);
            border-right: 1px solid var(--border-hairline);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 16px 12px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .brand-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 4px 8px 14px;
            border-bottom: 1px solid var(--border-light);
        }

        .brand-mark {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border-light);
            flex-shrink: 0;
            background: var(--bg-ground);
        }

        .brand-title {
            font-weight: 700;
            font-size: 14px;
            letter-spacing: -0.015em;
            color: var(--ink-primary);
        }

        .brand-sub {
            font-size: 11px;
            color: var(--ink-muted);
        }

        .role-pill {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 3px 7px;
            border-radius: 999px;
            border: 1px solid var(--border-hairline);
            background: var(--bg-ground);
            color: var(--ink-secondary);
            flex-shrink: 0;
        }

        .nav-section {
            margin-top: 16px;
        }

        .nav-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--ink-muted);
            padding: 0 10px 6px;
            letter-spacing: 0.02em;
        }

        .nav-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 10px;
            border-radius: var(--radius-md);
            color: var(--ink-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 13.5px;
            transition: background-color 160ms var(--ease-out), color 160ms var(--ease-out);
        }

        .nav-link:hover {
            background: var(--bg-hover);
            color: var(--ink-primary);
        }

        .nav-link.is-active {
            background: var(--accent);
            color: #FFFFFF;
            font-weight: 600;
        }

        .sidebar-footer {
            border-top: 1px solid var(--border-light);
            padding-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Shared Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 14px;
            border-radius: var(--radius-md);
            background: var(--accent);
            color: #FFFFFF;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 160ms var(--ease-out), transform 120ms var(--ease-out);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            color: #FFFFFF;
        }

        .btn-primary:active {
            transform: scale(0.99);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: var(--radius-md);
            background: var(--bg-ground);
            color: var(--ink-primary);
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid var(--border-hairline);
            cursor: pointer;
            transition: background-color 160ms var(--ease-out);
        }

        .btn-secondary:hover {
            background: var(--bg-surface);
        }

        .btn-danger-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 11px;
            border-radius: var(--radius-sm);
            background: transparent;
            color: var(--red-ink);
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(215, 0, 21, 0.24);
            cursor: pointer;
            transition: background-color 160ms var(--ease-out);
        }

        .btn-danger-ghost:hover {
            background: var(--red-bg);
        }

        .user-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 6px 8px;
            border-radius: var(--radius-md);
            background: var(--bg-ground);
            border: 1px solid var(--border-light);
        }

        .user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-sub {
            font-size: 11px;
            color: var(--ink-muted);
        }

        /* Main Area */
        .main-col {
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: var(--bg-ground);
        }

        .topbar {
            height: 58px;
            padding: 0 24px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--ink-primary);
        }

        .topbar-crumb {
            font-size: 12px;
            color: var(--ink-muted);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .content-wrap {
            padding: 20px 24px 40px;
            flex: 1;
        }

        .alert-banner {
            padding: 11px 14px;
            border-radius: var(--radius-md);
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid transparent;
        }

        .alert-success {
            background: var(--green-bg);
            color: var(--green-ink);
            border-color: rgba(36, 138, 61, 0.22);
        }

        .alert-error {
            background: var(--red-bg);
            color: var(--red-ink);
            border-color: rgba(215, 0, 21, 0.22);
        }

        /* ==============================================================
           Global Apple HIG Styling untuk Halaman Master, Log & Form
           ============================================================== */
        .content-wrap h1,
        .content-wrap h2,
        .content-wrap h3 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.015em;
            color: var(--ink-primary);
            margin: 0 0 12px 0;
        }

        .content-wrap > p {
            font-size: 13px;
            color: var(--ink-muted);
            margin-bottom: 14px;
        }

        /* Bar Filter / Toolbar di atas tabel (Master Tarif, Master Rak, dll.) */
        .content-wrap > div:not(.workspace-grid):not(.stats-grid):not(.section-card):not(.panel-card):not(.alert-banner):not(.table-wrap) {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .content-wrap > div:not(.workspace-grid):not(.stats-grid):not(.section-card):not(.panel-card):not(.alert-banner):not(.table-wrap) > a:not(.btn-primary):not(.btn-secondary):not(.filter-pill) {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            color: var(--ink-secondary);
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            transition: background-color 150ms var(--ease-out), color 150ms var(--ease-out);
        }

        .content-wrap > div:not(.workspace-grid):not(.stats-grid):not(.section-card):not(.panel-card):not(.alert-banner):not(.table-wrap) > a:not(.btn-primary):not(.btn-secondary):not(.filter-pill):hover {
            background: var(--bg-hover);
            color: var(--ink-primary);
        }

        /* Rapikan link filter kategori di Master Tarif jadi Pill Tabs */
        .content-wrap a[href*="service-categories"]:not(.btn-primary):not(.btn-secondary):not(table a) {
            display: inline-flex;
            align-items: center;
            padding: 6px 13px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            color: var(--ink-secondary);
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            margin: 0 6px 8px 0;
            transition: background-color 150ms var(--ease-out), color 150ms var(--ease-out);
        }

        .content-wrap a[href*="service-categories"]:not(.btn-primary):not(.btn-secondary):not(table a):hover {
            background: var(--bg-hover);
            color: var(--ink-primary);
        }

        .content-wrap > a.btn-primary,
        .content-wrap > a.btn-secondary {
            margin-bottom: 16px;
        }

        /* Standalone Form Card (Input Cucian, Edit, Master Form, Log Form) */
        .content-wrap form:not(.filter-col):not(.sort-bar):not(.inline-form) {
            background: var(--bg-ground);
            border: 1px solid var(--border-hairline);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-card);
            max-width: 780px;
        }

        .content-wrap form:not(.filter-col):not(.sort-bar):not(.inline-form) > div,
        .content-wrap form:not(.filter-col):not(.sort-bar):not(.inline-form) > p {
            margin-bottom: 14px;
        }

        .content-wrap form:not(.filter-col):not(.sort-bar):not(.inline-form) > div:last-child,
        .content-wrap form:not(.filter-col):not(.sort-bar):not(.inline-form) > p:last-child {
            margin-bottom: 0;
        }

        .content-wrap form label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-secondary);
            margin-bottom: 5px;
        }

        .content-wrap input[type="text"],
        .content-wrap input[type="number"],
        .content-wrap input[type="email"],
        .content-wrap input[type="password"],
        .content-wrap input[type="date"],
        .content-wrap select,
        .content-wrap textarea {
            width: 100%;
            padding: 9px 12px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-hairline);
            background: var(--bg-ground);
            color: var(--ink-primary);
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: border-color 150ms var(--ease-out);
        }

        .content-wrap textarea {
            min-height: 76px;
            resize: vertical;
        }

        .content-wrap input[type="checkbox"],
        .content-wrap input[type="radio"] {
            width: auto !important;
            accent-color: var(--accent);
            margin-right: 6px;
            vertical-align: middle;
        }

        .content-wrap input:focus,
        .content-wrap select:focus,
        .content-wrap textarea:focus {
            border-color: var(--accent);
        }

        .content-wrap form button[type="submit"]:not(.btn-secondary):not(.btn-danger-ghost) {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 18px;
            border-radius: var(--radius-md);
            background: var(--accent);
            color: #FFFFFF;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 160ms var(--ease-out);
        }

        .content-wrap form button[type="submit"]:not(.btn-secondary):not(.btn-danger-ghost):hover {
            background: var(--accent-hover);
        }

        .content-wrap form a:not(.btn-primary):not(.btn-secondary) {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: var(--radius-md);
            background: var(--bg-ground);
            color: var(--ink-primary);
            border: 1px solid var(--border-hairline);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            margin-left: 8px;
            transition: background-color 150ms var(--ease-out);
        }

        .content-wrap form a:not(.btn-primary):not(.btn-secondary):hover {
            background: var(--bg-surface);
        }

        /* Tabel Global (Master ID Rak, Master Tarif, Master User, Log, Laporan) */
        .content-wrap table:not(.hig-table) {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--bg-ground);
            border: 1px solid var(--border-hairline);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            font-size: 13px;
            margin-bottom: 20px;
        }

        .content-wrap table:not(.hig-table) th {
            text-align: left;
            padding: 11px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--ink-muted);
            background: var(--bg-subtle);
            border-bottom: 1px solid var(--border-light);
            white-space: nowrap;
        }

        .content-wrap table:not(.hig-table) td {
            padding: 11px 14px;
            border-bottom: 1px solid var(--border-light);
            color: var(--ink-secondary);
            vertical-align: middle;
        }

        .content-wrap table:not(.hig-table) tr:last-child td {
            border-bottom: none;
        }

        .content-wrap table:not(.hig-table) tbody tr:hover {
            background: var(--bg-subtle);
        }

        /* Reset form & rapikan tombol Edit + Hapus di dalam kolom AKSI tabel */
        .content-wrap table td:last-child {
            white-space: nowrap;
        }

        .content-wrap table td a:not(.btn-primary) {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 11px;
            border-radius: var(--radius-sm);
            background: var(--bg-ground);
            color: var(--ink-primary);
            border: 1px solid var(--border-hairline);
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            margin: 0;
            transition: background-color 150ms var(--ease-out);
        }

        .content-wrap table td a:not(.btn-primary):hover {
            background: var(--bg-surface);
        }

        .content-wrap table td form {
            display: inline-block !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 0 0 6px !important;
            box-shadow: none !important;
            max-width: none !important;
        }

        .content-wrap table td form button[type="submit"] {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            padding: 5px 11px !important;
            border-radius: var(--radius-sm) !important;
            background: transparent !important;
            color: var(--red-ink) !important;
            border: 1px solid rgba(215, 0, 21, 0.24) !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            height: auto !important;
            width: auto !important;
            cursor: pointer;
        }

        .content-wrap table td form button[type="submit"]:hover {
            background: var(--red-bg) !important;
        }

        @media (max-width: 900px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-hairline);
            }

            .topbar {
                padding: 0 16px;
            }

            .content-wrap {
                padding: 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
@php
    $authUser = auth()->user();
    $isPemilik = $authUser && method_exists($authUser, 'isPemilik') ? $authUser->isPemilik() : (($authUser->role ?? '') === 'pemilik');

    $logoPath = null;
    foreach (['rak-boim-logo', 'logo'] as $baseName) {
        foreach (['png', 'jpg', 'jpeg', 'webp'] as $ext) {
            if (file_exists(public_path("images/{$baseName}.{$ext}"))) {
                $logoPath = asset("images/{$baseName}.{$ext}");
                break 2;
            }
        }
    }

    $fallbackTitle = trim($__env->yieldContent('title', 'Dashboard Operasional'));
    $fallbackSubtitle = match(true) {
        request()->routeIs('dashboard') => 'Ringkasan cucian aktif, kapasitas rak, dan transaksi terbaru',
        request()->routeIs('storages.create') => 'Catat bundel cucian baru ke rak penyimpanan',
        request()->routeIs('storages.edit') => 'Perbarui status penyimpanan, pindah rak, atau serah terima',
        request()->routeIs('storages.*') => 'Pencarian cepat 4 digit nomor telepon, filter rak, dan serah terima',
        request()->routeIs('logs.*') => 'Rekap verifikasi setrika, penataan, pindah rak, dan serah terima',
        request()->routeIs('racks.*') => 'Daftar sekat lemari penyimpanan dan kapasitas maksimal rak',
        request()->routeIs('categories.*') => 'Pengaturan paket kiloan reguler, express, dan layanan satuan',
        request()->routeIs('users.*') => 'Manajemen akun Pemilik dan Staf operasional',
        request()->routeIs('reports.*') => 'Rekap laporan transaksi dan ekspor berkas CSV / PDF',
        default => 'Boim Laundry • Sistem Manajemen Rak & Penyimpanan',
    };
@endphp

<div class="app-shell">
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <div class="brand-mark">
                    @if($logoPath)
                        <img src="{{ $logoPath }}" alt="Logo Rak Boim" class="brand-logo">
                    @else
                        <span class="brand-logo mono" style="display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;background:var(--accent);color:#fff;">RB</span>
                    @endif
                    <div>
                        <div class="brand-title">Rak Boim</div>
                        <div class="brand-sub">Gudang Laundry</div>
                    </div>
                </div>
                <span class="role-pill">{{ $isPemilik ? 'Pemilik' : 'Staf' }}</span>
            </div>

            <div class="nav-section">
                <div class="nav-label">Operasional</div>
                <nav class="nav-list">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('storages.index') }}" class="nav-link {{ request()->routeIs('storages.*') ? 'is-active' : '' }}">
                        <span>Penataan Rak</span>
                    </a>
                    <a href="{{ route('logs.index') }}" class="nav-link {{ request()->routeIs('logs.*') ? 'is-active' : '' }}">
                        <span>Log Setrika &amp; Rak</span>
                    </a>
                </nav>
            </div>

            <div class="nav-section">
                <div class="nav-label">Master &amp; Laporan</div>
                <nav class="nav-list">
                    <a href="{{ route('racks.index') }}" class="nav-link {{ request()->routeIs('racks.*') ? 'is-active' : '' }}">
                        <span>Master ID Rak</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'is-active' : '' }}">
                        <span>Master Tarif</span>
                    </a>
                    @if($isPemilik)
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'is-active' : '' }}">
                            <span>Master User</span>
                        </a>
                    @endif
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'is-active' : '' }}">
                        <span>Laporan CSV / PDF</span>
                    </a>
                </nav>
            </div>

            <div class="nav-section">
                <div class="nav-label">Endpoint Publik</div>
                <nav class="nav-list">
                    <a href="{{ url('/api/v1/storages/track') }}" target="_blank" rel="noopener" class="nav-link">
                        <span>API Cek Cucian</span>
                        <span class="mono" style="font-size:10px; opacity:0.7;">JSON</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="sidebar-footer">
            <a href="{{ route('storages.create') }}" class="btn-primary">
                <span>+ Input Cucian</span>
            </a>

            @if($authUser)
                <div class="user-meta">
                    <div style="min-width:0;">
                        <div class="user-name">{{ $authUser->name }}</div>
                        <div class="user-role-sub">{{ $isPemilik ? 'Akses Penuh Pemilik' : 'Akses Operasional Staf' }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline-form" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-secondary" style="padding:5px 9px; font-size:11.5px;">Keluar</button>
                    </form>
                </div>
            @endif
        </div>
    </aside>

    <div class="main-col">
        <header class="topbar">
            <div>
                <div class="topbar-title">@yield('page_title', $fallbackTitle)</div>
                <div class="topbar-crumb">@yield('page_subtitle', $fallbackSubtitle)</div>
            </div>

            <div class="topbar-actions">
                @yield('topbar_actions')
            </div>
        </header>

        <main class="content-wrap">
            @if(session('success'))
                <div class="alert-banner alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-banner alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>