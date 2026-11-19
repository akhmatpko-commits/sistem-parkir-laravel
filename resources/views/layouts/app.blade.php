
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Sistem Parkir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * { box-sizing: border-box; }

        :root {
            --parkir-navy: #101b35;
            --parkir-blue: #315efb;
            --parkir-text: #172033;
            --parkir-muted: #718096;
            --parkir-border: #e8edf5;
            --parkir-surface: #ffffff;
        }

        html { scroll-behavior: smooth; }

        body {
            background:
                radial-gradient(circle at 92% 5%, rgba(49,94,251,.09), transparent 25%),
                linear-gradient(135deg, #f6f8fc 0%, #edf2f9 100%);
            color: var(--parkir-text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            letter-spacing: .1px;
            margin: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(165deg, #111d39 0%, #0b1224 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 24px 16px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            border-right: 1px solid rgba(255,255,255,.07);
            box-shadow: 12px 0 35px rgba(15,23,42,.10);
            scrollbar-width: thin;
            scrollbar-color: #475569 #101b35;
        }

        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        .sidebar h4 {
            padding: 13px 10px 20px;
            letter-spacing: 1.5px;
            font-size: 1.05rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #c5cee0;
            padding: 12px 14px;
            margin: 5px 0;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: .93rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .22s ease, color .22s ease, transform .22s ease, border-color .22s ease;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,.09);
            color: #fff;
            border-color: rgba(255,255,255,.08);
            transform: translateX(4px);
        }

        .sidebar .active {
            color: #fff;
            background: linear-gradient(100deg, #315efb, #4778ff);
            border-color: rgba(255,255,255,.14);
            box-shadow: 0 8px 20px rgba(49,94,251,.25);
        }

        .sidebar .menu-heading {
            display: block;
            color: #8493ad !important;
            padding: 0 12px;
            margin: 15px 0 8px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .sidebar hr {
            border-color: rgba(255,255,255,.15);
            margin: 22px 5px;
        }

        .sidebar form .btn {
            border: 0;
            border-radius: 11px;
            padding: 11px 14px;
            font-weight: 600;
            background: linear-gradient(100deg, #e14d5a, #c93649);
            box-shadow: 0 7px 18px rgba(201,54,73,.2);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .sidebar form .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(201,54,73,.28);
        }

        /* KONTEN UTAMA */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-width: 0;
            min-height: 100vh;
            padding: 28px;
            overflow-x: hidden;
        }

        /* TOPBAR */
        .topbar {
            position: relative;
            z-index: 1055;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(226,232,240,.9);
            border-radius: 18px;
            padding: 17px 22px;
            margin-bottom: 26px;
            box-shadow: 0 10px 35px rgba(25,42,70,.055);
            backdrop-filter: blur(12px);
        }

        .topbar h5 {
            color: #172033;
            letter-spacing: -.25px;
            font-size: 1.15rem;
        }

        .topbar small { font-size: .82rem; }

        .topbar .btn-light {
            width: 42px;
            height: 42px;
            border: 1px solid var(--parkir-border);
            border-radius: 12px;
            background: #f7f9fd;
            transition: .2s ease;
        }

        .topbar .btn-light:hover {
            background: #edf2ff;
            color: var(--parkir-blue);
            transform: translateY(-2px);
        }

        /* KARTU DASHBOARD */
        .stat-card,
        .card {
            border: 1px solid rgba(226,232,240,.85);
            border-radius: 17px !important;
            box-shadow: 0 9px 28px rgba(25,42,70,.055);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .stat-card:hover,
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 34px rgba(25,42,70,.09);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            background: white;
            padding: 23px;
            margin-bottom: 20px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 23px;
            flex-shrink: 0;
        }

        /* JUDUL */
        .main-content h1,
        .main-content h2,
        .main-content h3,
        .main-content h4 {
            color: #172033;
            font-weight: 700;
        }

        /* TABEL */
        .table-responsive {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 12px;
        }

        .table {
            --bs-table-bg: transparent;
            vertical-align: middle;
        }

        .table thead th {
            color: #64748b;
            background: #f5f7fb;
            border-bottom: 1px solid var(--parkir-border);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .45px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table td,
        .table th {
            padding: 13px 14px;
            border-color: #edf1f6;
        }

        .table tbody tr { transition: background .18s ease; }
        .table tbody tr:hover { background: #f7f9ff; }
        .table tbody tr:last-child td { border-bottom: 0; }

        /* TOMBOL */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            min-height: 36px;
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .btn:hover { transform: translateY(-1px); }

        .btn-primary {
            border-color: #315efb;
            background: linear-gradient(100deg, #315efb, #4778ff);
            box-shadow: 0 5px 14px rgba(49,94,251,.16);
        }

        .btn:focus-visible,
        .sidebar a:focus-visible {
            outline: 3px solid rgba(49,94,251,.35);
            outline-offset: 3px;
        }

        /* FORM */
        .form-control,
        .form-select {
            min-height: 43px;
            border-radius: 10px;
            border-color: #dfe6f0;
            padding: 9px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #7895ff;
            box-shadow: 0 0 0 .22rem rgba(49,94,251,.12);
        }

        /* DROPDOWN DAN NOTIFIKASI */
        .topbar .dropdown {
            position: relative;
            z-index: 1060;
        }

        .dropdown-menu {
            position: absolute;
            z-index: 1060 !important;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            padding: 8px;
            box-shadow: 0 16px 38px rgba(15,23,42,.13) !important;
        }

        .topbar .dropdown-menu {
            z-index: 1070 !important;
            max-width: calc(100vw - 30px);
        }

        .dropdown-item {
            border-radius: 9px;
            padding: 9px 11px;
            transition: background .2s ease;
        }

        .topbar .dropdown-item { white-space: normal; }
        .topbar .dropdown-item:hover { background: #edf2ff; }

        .badge {
            border-radius: 8px;
            padding: .48em .7em;
            font-weight: 600;
        }

        /* ANIMASI HALAMAN */
        body.page-enter .main-content {
            animation: parkirPageIn .55s cubic-bezier(.2,.75,.25,1) both;
        }

        body.page-enter .sidebar {
            animation: parkirSidebarIn .45s ease-out both;
        }

        body.page-exit .main-content {
            animation: parkirPageOut .22s ease-in both;
        }

        body.page-exit .sidebar {
            animation: parkirSidebarOut .22s ease-in both;
        }

        @keyframes parkirPageIn {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes parkirSidebarIn {
            from { opacity: 0; transform: translateX(-12px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes parkirPageOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(8px); }
        }

        @keyframes parkirSidebarOut {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(-8px); }
        }

        /* TABLET */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 15px 8px;
            }

            .sidebar .menu-text,
            .sidebar .brand-text { display: none; }

            .sidebar a {
                justify-content: center;
                text-align: center;
                padding: 12px 5px;
            }

            .sidebar a i { font-size: 1.2rem; }
            .sidebar .menu-heading { display: none; }

            .sidebar h4 {
                font-size: .9rem;
                padding: 12px 0;
            }

            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
                padding: 14px;
            }

            .topbar {
                padding: 14px;
                border-radius: 14px;
            }

            .topbar > div:last-child { gap: 8px !important; }

            .table td,
            .table th { padding: 10px; }
        }

        /* HP KECIL */
        @media (max-width: 480px) {
            .main-content { padding: 10px; }

            .topbar {
                flex-direction: column;
                align-items: stretch !important;
                border-radius: 13px;
                padding: 13px;
            }

            .topbar > div:last-child {
                justify-content: space-between;
                width: 100%;
            }

            .topbar h5 { font-size: 1rem; }

            .topbar .dropdown-menu {
                width: min(320px, calc(100vw - 100px)) !important;
            }

            .stat-card { padding: 16px; }

            .stat-icon {
                width: 42px;
                height: 42px;
                font-size: 19px;
            }

            .card { border-radius: 13px !important; }
            .btn { font-size: .85rem; }
        }

        /* AKSESIBILITAS */
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }

            body.page-enter .main-content,
            body.page-enter .sidebar,
            body.page-exit .main-content,
            body.page-exit .sidebar {
                animation: none !important;
            }

            *,
            *::before,
            *::after {
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="page-enter">

{{-- SIDEBAR KHUSUS PENGGUNA YANG SUDAH LOGIN --}}
@auth

<div class="sidebar">

    {{-- LOGO --}}
    <h4 class="fw-bold mb-4 text-center">
        <i class="bi bi-car-front-fill text-primary"></i>
        <span class="brand-text"> APP</span>
    </h4>

    {{-- MENU OWNER --}}
    @if(auth()->user()->role === 'owner')

        <small class="text-secondary menu-heading">MENU OWNER</small>

        <a href="{{ route('owner.dashboard') }}"
           class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span class="menu-text">Dashboard Owner</span>
        </a>

        <a href="{{ route('transactions.index') }}"
           class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span class="menu-text">Data Transaksi</span>
        </a>

        <a href="{{ route('reports.index') }}"
           class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i>
            <span class="menu-text">Laporan Parkir</span>
        </a>

    {{-- MENU ADMIN --}}
    @elseif(auth()->user()->role === 'admin')

        <small class="text-secondary menu-heading">MENU ADMIN</small>

        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span class="menu-text">Dashboard Admin</span>
        </a>

        <a href="{{ route('users.index') }}"
           class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span class="menu-text">Users</span>
        </a>

        <a href="{{ route('areas.index') }}"
           class="{{ request()->routeIs('areas.*') ? 'active' : '' }}">
            <i class="bi bi-p-square"></i>
            <span class="menu-text">Area Parkir</span>
        </a>

        <a href="{{ route('kendaraan.index') }}"
           class="{{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
            <i class="bi bi-car-front"></i>
            <span class="menu-text">Data Kendaraan</span>
        </a>

        <a href="{{ route('tarif.index') }}"
           class="{{ request()->routeIs('tarif.*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i>
            <span class="menu-text">Tarif Parkir</span>
        </a>

        <a href="{{ route('transactions.index') }}"
           class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span class="menu-text">Data Transaksi</span>
        </a>

        <a href="{{ route('reports.index') }}"
           class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i>
            <span class="menu-text">Laporan Parkir</span>
        </a>

        <a href="{{ route('admin.activity-logs.index') }}"
           class="{{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span class="menu-text">Log Aktivitas</span>
        </a>

    {{-- MENU PETUGAS --}}
    @elseif(auth()->user()->role === 'petugas')

        <small class="text-secondary menu-heading">MENU PETUGAS</small>

        <a href="{{ route('petugas.dashboard') }}"
           class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span class="menu-text">Dashboard Petugas</span>
        </a>

        <a href="{{ route('transactions.index') }}"
           class="{{ request()->routeIs('transactions.index') || request()->routeIs('transactions.show') || request()->routeIs('transactions.receipt') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span class="menu-text">Data Transaksi</span>
        </a>

        <a href="{{ route('transactions.create') }}"
           class="{{ request()->routeIs('transactions.create') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-right"></i>
            <span class="menu-text">Kendaraan Masuk</span>
        </a>

        <a href="{{ route('parking.index') }}"
           class="{{ request()->routeIs('parking.*') || request()->routeIs('transactions.checkout') || request()->routeIs('transactions.processCheckout') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-right"></i>
            <span class="menu-text">Kendaraan Keluar</span>
        </a>

        <a href="{{ route('parking.keluar') }}"
           class="{{ request()->routeIs('parking.keluar') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span class="menu-text">Data Kendaraan Keluar</span>
        </a>

        <a href="{{ route('petugas.slot-parkir') }}"
            class="{{ request()->routeIs('petugas.slot-parkir') ? 'active' : '' }}">
            <i class="bi bi-p-square"></i>
            <span class="menu-text">Slot Parkir</span>
        </a>

    @endif

    <hr>

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="btn btn-danger w-100">
            <i class="bi bi-box-arrow-right"></i>
            <span class="menu-text">Logout</span>
        </button>
    </form>

</div>

@endauth

{{-- KONTEN UTAMA --}}
<div class="main-content"
     style="{{ auth()->check() ? '' : 'margin-left:0; width:100%;' }}">

    {{-- TOPBAR KHUSUS PENGGUNA LOGIN --}}
    @auth

    <div class="topbar d-flex justify-content-between align-items-center">

        <div>
            <h5 class="mb-0 fw-bold">
                @yield('page-title')
            </h5>

            <small class="text-muted">
                Sistem Manajemen Parkir
            </small>
        </div>

        {{-- NOTIFIKASI DAN INFORMASI PENGGUNA --}}
        <div class="d-flex align-items-center gap-3">

            @php
                $notifications = auth()->user()
                    ->notifications()
                    ->latest()
                    ->take(5)
                    ->get();

                $jumlahBelumDibaca = auth()->user()
                    ->unreadNotifications()
                    ->count();
            @endphp

            {{-- IKON NOTIFIKASI --}}
            <div class="dropdown">

                <button
                    class="btn btn-light position-relative"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <i class="bi bi-bell fs-5"></i>

                    @if($jumlahBelumDibaca > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $jumlahBelumDibaca }}
                        </span>
                    @endif

                </button>

                {{-- DAFTAR NOTIFIKASI --}}
                <ul class="dropdown-menu dropdown-menu-end shadow"
                    style="width: 320px; max-height: 400px; overflow-y: auto;">

                    <li class="dropdown-header fw-bold">
                        Notifikasi Terbaru
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @forelse($notifications as $notification)

                        <li>
                            <a class="dropdown-item text-wrap"
                               href="{{ $notification->data['url'] ?? route('transactions.index') }}">

                                <div class="fw-bold">
                                    {{ $notification->data['judul'] ?? 'Notifikasi' }}
                                </div>

                                <small class="text-muted">
                                    {{ $notification->data['pesan'] ?? '' }}
                                </small>

                                <br>

                                <small class="text-secondary">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>

                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                    @empty

                        <li class="text-center text-muted p-3">
                            Belum ada notifikasi.
                        </li>

                    @endforelse

                </ul>
            </div>

            {{-- INFORMASI PENGGUNA --}}
            <div class="text-end">
                <strong>{{ auth()->user()->name }}</strong>
                <br>

                <span class="badge bg-primary">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

        </div>

    </div>

    @endauth

    {{-- ISI HALAMAN --}}
    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        confirmButtonColor: '#3085d6'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        confirmButtonColor: '#d33'
    });
</script>
@endif

@if(session('warning'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian!',
        text: @json(session('warning')),
        confirmButtonColor: '#f0ad4e'
    });
</script>
@endif

<script>
    // Animasi perpindahan halaman tanpa mengubah route atau form.
    document.addEventListener('click', function (event) {
        const link = event.target.closest('a[href]');
        if (!link) return;

        const href = link.getAttribute('href');

        if (!href || href.startsWith('#') ||
            link.target === '_blank' ||
            event.defaultPrevented ||
            event.button !== 0 ||
            event.ctrlKey || event.metaKey || event.shiftKey || event.altKey ||
            link.hasAttribute('download')) {
            return;
        }

        const destination = new URL(link.href, window.location.href);

        if (destination.origin !== window.location.origin ||
            destination.href === window.location.href) {
            return;
        }

        event.preventDefault();

        document.body.classList.remove('page-enter');
        document.body.classList.add('page-exit');

        window.setTimeout(function () {
            window.location.href = destination.href;
        }, 220);
    });

    // Animasi masuk saat halaman dibuka kembali.
    window.addEventListener('pageshow', function () {
        document.body.classList.remove('page-exit');
        document.body.classList.add('page-enter');
    });
</script>

@stack('scripts')

</body>
</html>
