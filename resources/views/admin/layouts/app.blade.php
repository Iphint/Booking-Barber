<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') – Invictocutz</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --gold: #C9A96E;
            --gold-light: #E4C896;
            --black: #0A0A0A;
            --dark: #111111;
            --dark-2: #1A1A1A;
            --dark-3: #222222;
            --dark-4: #2A2A2A;
            --white: #FAFAF8;
            --muted: #888888;
            --border: rgba(201,169,110,0.15);
            --success: #50c878;
            --warning: #EAB308;
            --danger: #ff6b6b;
            --info: #60a5fa;
            --sidebar-w: 260px;
            --font-display: 'Playfair Display', serif;
            --font-body: 'DM Sans', sans-serif;
            --radius: 6px;
            --radius-lg: 12px;
            --transition: 0.25s cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            background: var(--black);
            color: var(--white);
            font-family: var(--font-body);
            font-weight: 300;
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ───────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--dark-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
            transition: var(--transition);
        }
        .sidebar-brand {
            padding: 1.8rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .sidebar-brand .logo-icon { color: var(--gold); font-size: 1.1rem; }
        .sidebar-brand-name {
            font-family: var(--font-display);
            font-size: 1.05rem;
            letter-spacing: 0.08em;
            color: var(--white);
        }
        .sidebar-brand-sub {
            font-size: 0.65rem;
            color: var(--muted);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            display: block;
        }

        .sidebar-nav { flex: 1; padding: 1.2rem 0; overflow-y: auto; }
        .nav-section-label {
            font-size: 0.62rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 0.8rem 1.5rem 0.4rem;
            font-weight: 500;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            color: var(--muted);
            font-size: 0.88rem;
            transition: var(--transition);
            border-left: 2px solid transparent;
            position: relative;
        }
        .sidebar-link i { width: 18px; text-align: center; font-size: 0.9rem; }
        .sidebar-link:hover { color: var(--white); background: rgba(255,255,255,0.03); }
        .sidebar-link.active {
            color: var(--gold);
            background: rgba(201,169,110,0.06);
            border-left-color: var(--gold);
        }
        .sidebar-link .badge {
            margin-left: auto;
            background: var(--gold);
            color: var(--black);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 2rem;
            min-width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1.2rem 1.5rem;
            border-top: 1px solid var(--border);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 0.8rem;
        }
        .user-avatar {
            width: 34px; height: 34px;
            background: var(--gold);
            color: var(--black);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .user-name { font-size: 0.85rem; font-weight: 500; color: var(--white); display: block; }
        .user-role { font-size: 0.72rem; color: var(--muted); }
        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            background: rgba(255,107,107,0.08);
            border: 1px solid rgba(255,107,107,0.2);
            color: var(--danger);
            padding: 0.6rem 1rem;
            border-radius: var(--radius);
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-body);
            text-decoration: none;
            justify-content: center;
        }
        .btn-logout:hover { background: rgba(255,107,107,0.15); }

        /* ── Main Content ─────────────────── */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Topbar ───────────────────────── */
        .topbar {
            background: var(--dark-2);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-title {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--white);
        }
        .topbar-title span { color: var(--gold); font-style: italic; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-date {
            font-size: 0.78rem;
            color: var(--muted);
        }
        .topbar-visit {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(201,169,110,0.1);
            border: 1px solid var(--border);
            color: var(--gold);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            font-size: 0.78rem;
            transition: var(--transition);
        }
        .topbar-visit:hover { background: rgba(201,169,110,0.15); }

        /* ── Page Content ─────────────────── */
        .page-content { padding: 2rem; flex: 1; }

        /* ── Alert ────────────────────────── */
        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .alert-success { background: rgba(80,200,120,0.08); border: 1px solid rgba(80,200,120,0.25); color: var(--success); }
        .alert-error   { background: rgba(255,107,107,0.08); border: 1px solid rgba(255,107,107,0.25); color: var(--danger); }

        /* ── Mobile sidebar toggle ────────── */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.2rem;
            cursor: pointer;
            margin-right: 0.5rem;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 99;
        }
        .sidebar-overlay.active { display: block; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .page-content { padding: 1.2rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="logo-icon">✦</span>
        <div>
            <span class="sidebar-brand-name">INVICTOCUTZ</span>
            <span class="sidebar-brand-sub">Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-label">Overview</p>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>

        <p class="nav-section-label">Bookings</p>
        <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> All Bookings
            @php $pending = \App\Models\Booking::pending()->count(); @endphp
            @if($pending > 0)
                <span class="badge">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'paid']) }}" class="sidebar-link">
            <i class="fas fa-check-circle"></i> Paid
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="sidebar-link">
            <i class="fas fa-clock"></i> Pending
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="sidebar-link">
            <i class="fas fa-times-circle"></i> Cancelled
        </a>

        <p class="nav-section-label">Schedule</p>
        <a href="{{ route('admin.schedule') }}" class="sidebar-link {{ request()->routeIs('admin.schedule') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Today's Schedule
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">Administrator</span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- Main --}}
<div class="main-content">
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <h1 class="topbar-title">@yield('page-title', 'Dashboard') <span>·</span> Admin</h1>
        </div>
        <div class="topbar-right">
            <span class="topbar-date"><i class="far fa-calendar" style="color:var(--gold);margin-right:0.4rem;"></i>{{ now()->format('D, d M Y') }}</span>
            <a href="{{ route('home') }}" target="_blank" class="topbar-visit">
                <i class="fas fa-external-link-alt"></i> Visit Site
            </a>
        </div>
    </header>

    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
const toggle  = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');

toggle?.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
});
overlay?.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
});
</script>
@stack('scripts')
</body>
</html>