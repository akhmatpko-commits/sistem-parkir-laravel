
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Sistem Parkir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f1f5f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #0f172a;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 15px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #1e40af;
            color: white;
        }

        .sidebar .active {
            background: #2563eb;
            color: white;
        }

        .sidebar .menu-heading {
            display: block;
            margin: 15px 0 8px;
        }

        /* KONTEN UTAMA */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-width: 0;
            min-height: 100vh;
            padding: 25px;
            overflow-x: hidden;
        }

        /* TOPBAR */
        .topbar {
            width: 100%;
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
        }

        /* KARTU DASHBOARD */
        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 23px;
        }

        /* TABEL RESPONSIF */
        .table-responsive {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* TAMPILAN TABLET DAN HP */
        @media (max-width: 768px) {

            .sidebar {
                width: 70px;
                padding: 15px 8px;
            }

            .sidebar .menu-text,
            .sidebar .brand-text {
                display: none;
            }

            .sidebar a {
                text-align: center;
                padding: 12px 5px;
            }

            .sidebar .menu-heading {
                display: none;
            }

            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
                padding: 12px;
            }

            .topbar {
                padding: 12px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

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

        {{-- MENU USERS --}}
        <a href="{{ route('users.index') }}"
           class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span class="menu-text">Users</span>
        </a>

        {{-- MENU AREA PARKIR --}}
        <a href="{{ route('areas.index') }}"
           class="{{ request()->routeIs('areas.*') ? 'active' : '' }}">
            <i class="bi bi-p-square"></i>
            <span class="menu-text">Area Parkir</span>
        </a>

        {{-- MENU KENDARAAN --}}
        <a href="{{ route('kendaraan.index') }}"
           class="{{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
            <i class="bi bi-car-front"></i>
            <span class="menu-text">Data Kendaraan</span>
        </a>

        {{-- MENU TARIF --}}
        <a href="{{ route('tarif.index') }}"
           class="{{ request()->routeIs('tarif.*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i>
            <span class="menu-text">Tarif Parkir</span>
        </a>

        {{-- MENU REGISTER PETUGAS --}}
        <a href="{{ route('register.create') }}"
           class="{{ request()->routeIs('register.*') ? 'active' : '' }}">
            <i class="bi bi-person-plus"></i>
            <span class="menu-text">Register Petugas</span>
        </a>

        {{-- MENU TRANSAKSI --}}
        <a href="{{ route('transactions.index') }}"
           class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span class="menu-text">Data Transaksi</span>
        </a>

        {{-- MENU LAPORAN --}}
        <a href="{{ route('reports.index') }}"
           class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i>
            <span class="menu-text">Laporan Parkir</span>
        </a>

        {{-- MENU LOG AKTIVITAS --}}
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
           class="{{ request()->routeIs('transactions.index') || request()->routeIs('transactions.show') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span class="menu-text">Data Transaksi</span>
        </a>

        <a href="{{ route('transactions.create') }}"
           class="{{ request()->routeIs('transactions.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            <span class="menu-text">Kendaraan Masuk</span>
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

{{-- KONTEN UTAMA --}}
<div class="main-content">

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

@stack('scripts')

</body>
</html>
