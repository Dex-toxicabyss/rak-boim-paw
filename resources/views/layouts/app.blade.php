<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rak Boim') — Boim Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --rb-sidebar: #0F172A;
            --rb-sidebar-hover: #1E293B;
            --rb-primary: #1D4ED8;
            --rb-bg: #F8FAFC;
            --rb-border: #E2E8F0;
            --rb-text: #0F172A;
            --rb-muted: #64748B;
        }
        body {
            background-color: var(--rb-bg);
            color: var(--rb-text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 0.9375rem;
        }
        .rb-shell { min-height: 100vh; display: flex; }
        .rb-sidebar {
            width: 248px;
            background-color: var(--rb-sidebar);
            color: #E2E8F0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .rb-brand {
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .rb-brand-title {
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.04em;
            color: #FFFFFF;
            margin: 0;
        }
        .rb-brand-sub {
            font-size: 0.78rem;
            color: #94A3B8;
            margin: 0.15rem 0 0;
        }
        .rb-nav { padding: 0.75rem; flex: 1; }
        .rb-nav-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748B;
            padding: 0.75rem 0.75rem 0.25rem;
            font-weight: 600;
        }
        .rb-nav-link {
            display: block;
            padding: 0.55rem 0.85rem;
            border-radius: 6px;
            color: #CBD5E1;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 0.2rem;
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .rb-nav-link:hover { background-color: var(--rb-sidebar-hover); color: #FFFFFF; }
        .rb-nav-link.active { background-color: var(--rb-primary); color: #FFFFFF; }
        .rb-main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .rb-topbar {
            background: #FFFFFF;
            border-bottom: 1px solid var(--rb-border);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .rb-content { padding: 1.5rem; flex: 1; }
        .rb-card {
            background: #FFFFFF;
            border: 1px solid var(--rb-border);
            border-radius: 8px;
        }
        .tnum { font-variant-numeric: tabular-nums; }
        @media (max-width: 991.98px) {
            .rb-sidebar { display: none; }
            .rb-content { padding: 1rem; }
            .rb-topbar { padding: 0.75rem 1rem; }
        }
    </style>
</head>
<body>
<div class="rb-shell">
    {{-- Desktop Sidebar --}}
    <aside class="rb-sidebar">
        <div class="rb-brand">
            <p class="rb-brand-title">RAK BOIM</p>
            <p class="rb-brand-sub">Gudang Boim Laundry</p>
        </div>
        <nav class="rb-nav">
            <div class="rb-nav-label">Operasional</div>
            <a href="{{ route('dashboard') }}" class="rb-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('storages.index') }}" class="rb-nav-link {{ request()->routeIs('storages.*') ? 'active' : '' }}">Penataan Rak</a>
            <a href="{{ route('logs.index') }}" class="rb-nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}">Log Setrika & Rak</a>

            <div class="rb-nav-label">Data Master</div>
            <a href="{{ route('racks.index') }}" class="rb-nav-link {{ request()->routeIs('racks.*') ? 'active' : '' }}">Master ID Rak</a>
            <a href="{{ route('categories.index') }}" class="rb-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">Master Tarif</a>

            @if(auth()->user()->isPemilik())
                <a href="{{ route('users.index') }}" class="rb-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Master User</a>
                <div class="rb-nav-label">Pelaporan</div>
                <a href="{{ route('reports.index') }}" class="rb-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">Laporan CSV / PDF</a>
            @endif
        </nav>
        <div class="p-3 border-top border-secondary border-opacity-25">
            <div class="small text-white fw-semibold">{{ auth()->user()->name }}</div>
            <div class="small text-secondary mb-2">Peran: {{ ucfirst(auth()->user()->role) }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">Keluar</button>
            </form>
        </div>
    </aside>

    {{-- Mobile Offcanvas Drawer --}}
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header border-bottom border-secondary border-opacity-25">
            <h5 class="offcanvas-title fw-bold">RAK BOIM</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-2">
            <a href="{{ route('dashboard') }}" class="rb-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('storages.index') }}" class="rb-nav-link {{ request()->routeIs('storages.*') ? 'active' : '' }}">Penataan Rak</a>
            <a href="{{ route('logs.index') }}" class="rb-nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}">Log Setrika & Rak</a>
            <a href="{{ route('racks.index') }}" class="rb-nav-link {{ request()->routeIs('racks.*') ? 'active' : '' }}">Master ID Rak</a>
            <a href="{{ route('categories.index') }}" class="rb-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">Master Tarif</a>
            @if(auth()->user()->isPemilik())
                <a href="{{ route('users.index') }}" class="rb-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Master User</a>
                <a href="{{ route('reports.index') }}" class="rb-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">Laporan CSV / PDF</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="mt-auto p-2">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">Keluar</button>
            </form>
        </div>
    </div>

    <div class="rb-main">
        <header class="rb-topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                    Menu
                </button>
                <h1 class="h5 mb-0 fw-semibold">@yield('heading', 'Dashboard')</h1>
            </div>
            <span class="badge text-bg-light border text-dark">
                {{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})
            </span>
        </header>

        <main class="rb-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <div class="fw-semibold mb-1">Periksa kembali data yang dimasukkan:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
