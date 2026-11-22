<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Rak Boim — Sistem Manajemen Gudang Boim Laundry')</title>

  <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ==========================================================================
       DESIGN TOKENS — APPLE HIG WHITE PRIMARY (RAK BOIM)
       ========================================================================== */
    :root {
      --bg-ground: #FFFFFF;
      --bg-surface: #F5F5F7;
      --bg-surface-hover: #ECECEF;
      --border-hairline: #D2D2D7;
      --border-subtle: #E8E8ED;

      --ink-primary: #1D1D1F;
      --ink-secondary: #515154;
      --ink-muted: #86868B;

      --accent: #0071E3;
      --accent-hover: #0062C4;
      --accent-soft: rgba(0, 113, 227, 0.09);

      --status-green: #248A3D;
      --status-green-bg: rgba(36, 138, 61, 0.10);
      --status-amber: #B25000;
      --status-amber-bg: rgba(178, 80, 0, 0.10);
      --status-red: #D70015;
      --status-red-bg: rgba(215, 0, 21, 0.10);

      --radius-sm: 8px;
      --radius-md: 10px;
      --radius-card: 14px;
      --radius-lg: 18px;

      --shadow-card: 0 1px 2px rgba(0, 0, 0, 0.04);
      --shadow-card-hover: 0 4px 16px rgba(0, 0, 0, 0.06);

      --ease-apple: cubic-bezier(0.16, 1, 0.3, 1);
      --dur-fast: 180ms;
      --dur-drawer: 280ms;

      --font-sans: "Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", sans-serif;
      --font-mono: "JetBrains Mono", "SF Mono", ui-monospace, SFMono-Regular, monospace;

      --sidebar-w: 236px;
      --topbar-h: 56px;
    }

    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      height: 100%;
      background-color: var(--bg-ground);
      color: var(--ink-primary);
      font-family: var(--font-sans);
      font-size: 14px;
      line-height: 1.45;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    button, input, select, textarea {
      font-family: inherit;
      font-size: inherit;
      color: inherit;
    }

    button {
      cursor: pointer;
      border: none;
      background: transparent;
    }

    .mono {
      font-family: var(--font-mono);
      font-variant-numeric: tabular-nums;
    }

    /* ==========================================================================
       APP SHELL (SIDEBAR + MAIN CONTENT)
       ========================================================================== */
    .app-shell {
      display: flex;
      min-height: 100vh;
      width: 100%;
      background: var(--bg-ground);
    }

    /* Left Sidebar */
    .sidebar {
      width: var(--sidebar-w);
      min-width: var(--sidebar-w);
      background: var(--bg-surface);
      border-right: 1px solid var(--border-hairline);
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      height: 100vh;
      z-index: 40;
      transition: transform var(--dur-drawer) var(--ease-apple);
    }

    .sidebar-brand {
      height: var(--topbar-h);
      padding: 0 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border-subtle);
      flex-shrink: 0;
    }

    .brand-lockup {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .brand-mark {
      width: 28px;
      height: 28px;
      border-radius: 8px;
      background: var(--ink-primary);
      color: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .brand-title {
      font-size: 14px;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: var(--ink-primary);
      line-height: 1.1;
    }

    .brand-sub {
      font-size: 11px;
      color: var(--ink-muted);
      font-weight: 500;
      margin-top: 1px;
    }

    .sidebar-scroll {
      flex: 1;
      overflow-y: auto;
      padding: 14px 12px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    /* Active User Card */
    .user-profile-card {
      background: #FFFFFF;
      border: 1px solid var(--border-hairline);
      border-radius: 12px;
      padding: 10px;
      box-shadow: var(--shadow-card);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-avatar {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: var(--bg-surface);
      border: 1px solid var(--border-hairline);
      font-size: 11.5px;
      font-weight: 700;
      color: var(--ink-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      text-transform: uppercase;
    }

    .user-name {
      font-size: 12.5px;
      font-weight: 700;
      color: var(--ink-primary);
      line-height: 1.2;
    }

    .user-role-tag {
      font-size: 11px;
      color: var(--ink-muted);
      text-transform: capitalize;
    }

    /* Navigation Groups */
    .nav-group-label {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.07em;
      color: var(--ink-muted);
      padding: 0 8px 6px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .nav-list {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .nav-item {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 10px;
      border-radius: var(--radius-md);
      font-size: 13px;
      font-weight: 500;
      color: var(--ink-secondary);
      transition: background var(--dur-fast) var(--ease-apple), color var(--dur-fast) var(--ease-apple);
    }

    .nav-item-left {
      display: flex;
      align-items: center;
      gap: 9px;
      min-width: 0;
    }

    .nav-item svg {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
      stroke: currentColor;
    }

    .nav-item:hover {
      background: rgba(29, 29, 31, 0.05);
      color: var(--ink-primary);
    }

    .nav-item.active {
      background: #FFFFFF;
      color: var(--accent);
      font-weight: 600;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .nav-badge {
      font-size: 10.5px;
      font-family: var(--font-mono);
      font-weight: 500;
      color: var(--ink-muted);
      background: rgba(29, 29, 31, 0.05);
      padding: 1px 6px;
      border-radius: 99px;
    }

    /* Sidebar Footer */
    .sidebar-footer {
      padding: 12px;
      border-top: 1px solid var(--border-subtle);
      display: flex;
      flex-direction: column;
      gap: 8px;
      flex-shrink: 0;
    }

    /* Shared Buttons & Controls */
    .btn-primary {
      background: var(--accent);
      color: #FFFFFF;
      font-weight: 600;
      font-size: 13px;
      padding: 8px 14px;
      border-radius: var(--radius-md);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      transition: background var(--dur-fast) var(--ease-apple), transform 120ms var(--ease-apple);
      white-space: nowrap;
    }

    .btn-primary:hover {
      background: var(--accent-hover);
      color: #FFFFFF;
    }

    .btn-primary.full {
      width: 100%;
    }

    .btn-secondary {
      background: #FFFFFF;
      color: var(--ink-primary);
      border: 1px solid var(--border-hairline);
      font-weight: 600;
      font-size: 12.5px;
      padding: 7px 12px;
      border-radius: var(--radius-md);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all var(--dur-fast) var(--ease-apple);
      white-space: nowrap;
    }

    .btn-secondary:hover {
      background: var(--bg-surface);
      border-color: #BDBDC4;
    }

    .btn-danger {
      background: var(--status-red-bg);
      color: var(--status-red);
      border: 1px solid rgba(215, 0, 21, 0.22);
      font-weight: 600;
      font-size: 12.5px;
      padding: 7px 12px;
      border-radius: var(--radius-md);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all var(--dur-fast) var(--ease-apple);
    }

    .btn-danger:hover {
      background: var(--status-red);
      color: #FFFFFF;
    }

    /* Main Workspace Column */
    .main-workspace {
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      background: var(--bg-ground);
    }

    .topbar {
      height: var(--topbar-h);
      min-height: var(--topbar-h);
      border-bottom: 1px solid var(--border-hairline);
      padding: 0 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      background: var(--bg-ground);
      position: sticky;
      top: 0;
      z-index: 30;
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 10px;
      min-width: 0;
    }

    .mobile-menu-btn {
      display: none;
      width: 34px;
      height: 34px;
      border-radius: 9px;
      border: 1px solid var(--border-hairline);
      align-items: center;
      justify-content: center;
      color: var(--ink-primary);
    }

    .breadcrumb {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13.5px;
    }

    .breadcrumb-root {
      color: var(--ink-muted);
      font-weight: 500;
    }

    .breadcrumb-sep {
      color: #C7C7CC;
    }

    .breadcrumb-current {
      color: var(--ink-primary);
      font-weight: 600;
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .role-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 10px;
      border-radius: 99px;
      background: var(--bg-surface);
      border: 1px solid var(--border-hairline);
      font-size: 12px;
      font-weight: 600;
      color: var(--ink-primary);
    }

    .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      flex-shrink: 0;
    }
    .dot-green { background: var(--status-green); }
    .dot-amber { background: var(--status-amber); }
    .dot-red { background: var(--status-red); }

    .workspace-content {
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    /* Flash Alert Banner */
    .flash-alert {
      padding: 12px 16px;
      border-radius: var(--radius-md);
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border: 1px solid var(--border-hairline);
    }
    .flash-success {
      background: var(--status-green-bg);
      color: var(--status-green);
      border-color: rgba(36, 138, 61, 0.25);
    }
    .flash-error {
      background: var(--status-red-bg);
      color: var(--status-red);
      border-color: rgba(215, 0, 21, 0.25);
    }

    /* Reusable Apple HIG Components for All Child Views */
    .summary-banner {
      background: var(--bg-surface);
      border: 1px solid var(--border-hairline);
      border-radius: var(--radius-lg);
      padding: 20px 22px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
    }

    .summary-banner h1 {
      font-size: 19px;
      font-weight: 700;
      letter-spacing: -0.025em;
      color: var(--ink-primary);
      margin-bottom: 4px;
    }

    .summary-banner p {
      font-size: 13px;
      color: var(--ink-muted);
    }

    .apple-card {
      background: #FFFFFF;
      border: 1px solid var(--border-hairline);
      border-radius: var(--radius-card);
      box-shadow: var(--shadow-card);
      overflow: hidden;
    }

    .rack-pill {
      font-family: var(--font-mono);
      font-size: 11.5px;
      font-weight: 600;
      color: var(--ink-primary);
      background: #FFFFFF;
      border: 1px solid var(--border-hairline);
      padding: 2px 7px;
      border-radius: 6px;
      display: inline-block;
    }

    .status-pill {
      font-size: 11px;
      font-weight: 600;
      padding: 3px 8px;
      border-radius: 99px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    .status-tersimpan { background: var(--accent-soft); color: var(--accent); }
    .status-siap_diambil { background: var(--status-amber-bg); color: var(--status-amber); }
    .status-selesai { background: var(--status-green-bg); color: var(--status-green); }

    .form-input, .form-select {
      width: 100%;
      padding: 8px 11px;
      background: #FFFFFF;
      border: 1px solid var(--border-hairline);
      border-radius: var(--radius-md);
      font-size: 13px;
      color: var(--ink-primary);
      outline: none;
      transition: border-color var(--dur-fast) var(--ease-apple), box-shadow var(--dur-fast) var(--ease-apple);
    }

    .form-input:focus, .form-select:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-soft);
    }

    table.apple-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 13px;
    }

    table.apple-table th {
      background: var(--bg-surface);
      color: var(--ink-muted);
      font-size: 11.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      padding: 11px 14px;
      border-bottom: 1px solid var(--border-hairline);
      white-space: nowrap;
    }

    table.apple-table td {
      padding: 12px 14px;
      border-bottom: 1px solid var(--border-subtle);
      color: var(--ink-primary);
      vertical-align: middle;
    }

    table.apple-table tbody tr:hover {
      background: #FAFAFC;
    }

    table.apple-table tbody tr:last-child td {
      border-bottom: none;
    }

    .sidebar-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(29, 29, 31, 0.25);
      z-index: 35;
    }

    @media (max-width: 960px) {
      .mobile-menu-btn {
        display: inline-flex;
      }
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        transform: translateX(-100%);
      }
      .sidebar.open {
        transform: translateX(0);
      }
      .sidebar-backdrop.open {
        display: block;
      }
      .topbar {
        padding: 0 14px;
      }
      .workspace-content {
        padding: 14px;
      }
      .role-pill {
        display: none;
      }
    }
  </style>
  @stack('styles')
</head>
<body>
  <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleMobileSidebar(false)"></div>

  <div class="app-shell">
    <!-- ======================================================================
         1. LEFT SIDEBAR (APPLE HIG #F5F5F7)
         ====================================================================== -->
    <aside class="sidebar" id="appSidebar">
      <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-lockup">
          <div class="brand-mark" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2"></rect>
              <line x1="3" y1="9" x2="21" y2="9"></line>
              <line x1="3" y1="15" x2="21" y2="15"></line>
              <line x1="12" y1="3" x2="12" y2="21"></line>
            </svg>
          </div>
          <div>
            <div class="brand-title">Rak Boim</div>
            <div class="brand-sub">Boim Laundry</div>
          </div>
        </a>
        <button type="button" class="mobile-menu-btn" onclick="toggleMobileSidebar(false)" aria-label="Tutup Menu">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <div class="sidebar-scroll">
        <!-- Logged-in User Card -->
        @auth
        <div class="user-profile-card">
          <div class="user-avatar">{{ substr(auth()->user()->name, 0, 2) }}</div>
          <div style="min-width:0;">
            <div class="user-name" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
            <div class="user-role-tag">{{ auth()->user()->role === 'pemilik' ? 'Pemilik · Full Access' : 'Staf · Operasional' }}</div>
          </div>
        </div>
        @endauth

        <!-- Group: UTAMA -->
        <div>
          <div class="nav-group-label">Utama</div>
          <div class="nav-list">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Dashboard</span>
              </span>
            </a>

            <a href="{{ route('laundry-storages.index') }}" class="nav-item {{ request()->routeIs('laundry-storages.*') ? 'active' : '' }}">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                <span>Penataan Rak</span>
              </span>
            </a>

            @if(Route::has('storage-logs.index'))
            <a href="{{ route('storage-logs.index') }}" class="nav-item {{ request()->routeIs('storage-logs.*') ? 'active' : '' }}">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg>
                <span>Log Setrika & Rak</span>
              </span>
            </a>
            @endif

            @if(Route::has('public.track'))
            <a href="{{ route('public.track') }}" target="_blank" class="nav-item">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span>Portal Cek Pelanggan</span>
              </span>
              <span class="nav-badge">Publik</span>
            </a>
            @endif
          </div>
        </div>

        <!-- Group: MASTER & LAPORAN -->
        <div>
          <div class="nav-group-label">
            <span>Data Master & Laporan</span>
            <span>{{ auth()->check() && auth()->user()->isPemilik() ? 'Full' : 'Read' }}</span>
          </div>
          <div class="nav-list">
            @if(Route::has('racks.index'))
            <a href="{{ route('racks.index') }}" class="nav-item {{ request()->routeIs('racks.*') ? 'active' : '' }}">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="12" y1="3" x2="12" y2="21"/></svg>
                <span>Master ID Rak</span>
              </span>
            </a>
            @endif

            @if(Route::has('service-categories.index'))
            <a href="{{ route('service-categories.index') }}" class="nav-item {{ request()->routeIs('service-categories.*') ? 'active' : '' }}">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <span>Master Tarif Layanan</span>
              </span>
            </a>
            @endif

            @if(auth()->check() && auth()->user()->isPemilik() && Route::has('users.index'))
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Master User</span>
              </span>
            </a>
            @endif

            @if(Route::has('reports.index'))
            <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
              <span class="nav-item-left">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                <span>Laporan CSV / PDF</span>
              </span>
            </a>
            @endif
          </div>
        </div>
      </div>

      <!-- Sidebar Footer: Quick Input & Logout -->
      <div class="sidebar-footer">
        <a href="{{ route('laundry-storages.create') }}" class="btn-primary full">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          <span>Input Cucian</span>
        </a>

        @auth
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn-secondary" style="width:100%; justify-content:center; color:var(--ink-secondary);">
            Keluar Sistem
          </button>
        </form>
        @endauth
      </div>
    </aside>

    <!-- ======================================================================
         2. RIGHT MAIN WORKSPACE
         ====================================================================== -->
    <main class="main-workspace">
      <header class="topbar">
        <div class="topbar-left">
          <button type="button" class="mobile-menu-btn" onclick="toggleMobileSidebar(true)" aria-label="Buka Navigasi">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
          <nav class="breadcrumb" aria-label="Breadcrumb">
            <span class="breadcrumb-root">Rak Boim</span>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-current">@yield('page_title', 'Operasional Gudang')</span>
          </nav>
        </div>

        <div class="topbar-right">
          @auth
          <div class="role-pill">
            <span class="dot {{ auth()->user()->isPemilik() ? 'dot-green' : 'dot-amber' }}"></span>
            <span>{{ ucfirst(auth()->user()->role) }} · {{ auth()->user()->name }}</span>
          </div>
          @endauth

          <a href="{{ route('laundry-storages.create') }}" class="btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span>Input Cucian</span>
          </a>
        </div>
      </header>

      <div class="workspace-content">
        @if(session('success'))
          <div class="flash-alert flash-success">
            <span>{{ session('success') }}</span>
          </div>
        @endif

        @if(session('error'))
          <div class="flash-alert flash-error">
            <span>{{ session('error') }}</span>
          </div>
        @endif

        @yield('content')
      </div>
    </main>
  </div>

  <script>
    function toggleMobileSidebar(open) {
      document.getElementById('appSidebar').classList.toggle('open', open);
      document.getElementById('sidebarBackdrop').classList.toggle('open', open);
    }
  </script>
  @stack('scripts')
</body>
</html>