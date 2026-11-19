
@php
    $role = auth()->user()->role;

    $isPetugas = $role === 'petugas';

    $jumlahMasuk = $kendaraanMasuk ?? 0;
    $jumlahKeluar = $kendaraanKeluar ?? 0;
    $jumlahTotal = $totalKendaraan ?? 0;
    $pendapatan = $totalPendapatan ?? 0;
    $area = $totalArea ?? 0;

    $totalAktivitas = $jumlahMasuk + $jumlahKeluar;

    $persenMasuk = $totalAktivitas > 0
        ? ($jumlahMasuk / $totalAktivitas) * 100
        : 0;

    $persenKeluar = $totalAktivitas > 0
        ? ($jumlahKeluar / $totalAktivitas) * 100
        : 0;
@endphp

<style>
    /* DASHBOARD MODERN */
    .parkir-dashboard {
        color: #e5eaf5;
        padding-bottom: 25px;
    }

    .main-content:has(.parkir-dashboard) {
        background: #0b1120;
    }

    .main-content:has(.parkir-dashboard) .topbar {
        background: #151e30;
        border: 1px solid #29354a;
        color: white;
        border-radius: 12px;
        box-shadow: none;
    }

    .main-content:has(.parkir-dashboard) .topbar h5,
    .main-content:has(.parkir-dashboard) .topbar strong {
        color: white;
    }

    .main-content:has(.parkir-dashboard) .topbar small {
        color: #94a3b8 !important;
    }

    .main-content:has(.parkir-dashboard) .sidebar {
        background: #101827;
        box-shadow: none;
        border-right: 1px solid #263247;
    }

    .parkir-dashboard .dashboard-heading {
        color: #f8fafc;
        font-weight: 800;
        font-size: 24px;
        letter-spacing: -.5px;
    }

    .parkir-dashboard .dashboard-subtitle {
        color: #94a3b8;
        font-size: 13px;
    }

    .parkir-dashboard .dark-card {
        background: #151e30;
        border: 1px solid #29354a;
        border-radius: 12px;
        padding: 20px;
        height: 100%;
        box-shadow: none;
        transition: .2s;
    }

    .parkir-dashboard .dark-card:hover {
        transform: translateY(-3px);
        border-color: #3b82f6;
    }

    .parkir-dashboard .stat-label {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .parkir-dashboard .stat-number {
        color: #f8fafc;
        font-size: 27px;
        font-weight: 800;
        margin-top: 12px;
        margin-bottom: 4px;
    }

    .parkir-dashboard .stat-description {
        color: #64748b;
        font-size: 11px;
    }

    .parkir-dashboard .stat-icon {
        width: 43px;
        height: 43px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .parkir-dashboard .icon-blue {
        background: rgba(59,130,246,.15);
        color: #60a5fa;
    }

    .parkir-dashboard .icon-green {
        background: rgba(16,185,129,.15);
        color: #34d399;
    }

    .parkir-dashboard .icon-orange {
        background: rgba(249,115,22,.15);
        color: #fb923c;
    }

    .parkir-dashboard .icon-purple {
        background: rgba(168,85,247,.15);
        color: #c084fc;
    }

    .parkir-dashboard .section-title {
        color: #f1f5f9;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .parkir-dashboard .section-subtitle {
        color: #64748b;
        font-size: 11px;
    }

    .parkir-dashboard .progress {
        height: 9px;
        background: #273449;
        border-radius: 20px;
    }

    .parkir-dashboard .progress-bar {
        border-radius: 20px;
    }

    .parkir-dashboard .dark-table {
        color: #cbd5e1;
        font-size: 12px;
        margin-bottom: 0;
    }

    .parkir-dashboard .dark-table thead th {
        background: #1b273b;
        color: #94a3b8;
        border-bottom: 1px solid #334155;
        padding: 14px 12px;
        font-size: 10px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .parkir-dashboard .dark-table tbody td {
        background: #151e30;
        color: #cbd5e1;
        border-bottom: 1px solid #29354a;
        padding: 13px 12px;
        vertical-align: middle;
    }

    .parkir-dashboard .dark-table tbody tr:hover td {
        background: #1b2940;
    }

    .parkir-dashboard .quick-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        background: #151e30;
        border: 1px solid #29354a;
        border-radius: 11px;
        text-decoration: none;
        color: #e2e8f0;
        height: 100%;
        transition: .2s;
    }

    .parkir-dashboard .quick-link:hover {
        background: #1d2b43;
        border-color: #3b82f6;
        color: white;
        transform: translateY(-2px);
    }

    .parkir-dashboard .quick-link i {
        font-size: 22px;
        color: #60a5fa;
    }

    .parkir-dashboard .quick-link small {
        color: #94a3b8;
        display: block;
        font-size: 11px;
    }

    .parkir-dashboard .badge-masuk {
        background: rgba(16,185,129,.15);
        color: #34d399;
    }

    .parkir-dashboard .badge-keluar {
        background: rgba(59,130,246,.15);
        color: #60a5fa;
    }

    .parkir-dashboard .badge-status {
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
    }

    .parkir-dashboard .dashboard-footer {
        color: #64748b;
        font-size: 11px;
        border-top: 1px solid #29354a;
        padding-top: 15px;
    }

    .parkir-dashboard .btn-dashboard {
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 9px 15px;
        font-size: 12px;
        text-decoration: none;
    }

    .parkir-dashboard .btn-dashboard:hover {
        background: #1d4ed8;
        color: white;
    }

    .parkir-dashboard .empty-data {
        color: #64748b;
        padding: 30px !important;
        text-align: center;
    }

    @media(max-width: 768px) {
        .parkir-dashboard .dashboard-heading {
            font-size: 20px;
        }

        .parkir-dashboard .stat-number {
            font-size: 23px;
        }

        .parkir-dashboard .dark-card {
            padding: 15px;
        }
    }
</style>

<div class="parkir-dashboard">

    {{-- JUDUL DASHBOARD --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h3 class="dashboard-heading mb-1">
                Overview Dashboard
            </h3>

            <p class="dashboard-subtitle mb-0">
                Selamat datang, {{ auth()->user()->name }}.
                Berikut ringkasan aktivitas sistem parkir.
            </p>
        </div>

        @if($role === 'admin' || $role === 'petugas')
            <a href="{{ route('transactions.create') }}"
               class="btn-dashboard">
                <i class="bi bi-plus-circle me-1"></i>
                Kendaraan Masuk
            </a>
        @endif

    </div>

    {{-- KARTU STATISTIK ADMIN DAN OWNER --}}
    @if(!$isPetugas)

        <div class="row g-3 mb-3">

            <div class="col-6 col-xl-3">
                <div class="dark-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stat-label">Total Kendaraan</div>
                            <div class="stat-number">
                                {{ number_format($jumlahTotal, 0, ',', '.') }}
                            </div>
                            <div class="stat-description">
                                Seluruh data kendaraan
                            </div>
                        </div>

                        <div class="stat-icon icon-blue">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="dark-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stat-label">Kendaraan Masuk</div>
                            <div class="stat-number">
                                {{ number_format($jumlahMasuk, 0, ',', '.') }}
                            </div>
                            <div class="stat-description">
                                Sedang berada di parkiran
                            </div>
                        </div>

                        <div class="stat-icon icon-green">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="dark-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stat-label">Kendaraan Keluar</div>
                            <div class="stat-number">
                                {{ number_format($jumlahKeluar, 0, ',', '.') }}
                            </div>
                            <div class="stat-description">
                                Transaksi selesai
                            </div>
                        </div>

                        <div class="stat-icon icon-orange">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="dark-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stat-label">Total Pendapatan</div>
                            <div class="stat-number" style="font-size:20px">
                                Rp {{ number_format($pendapatan, 0, ',', '.') }}
                            </div>
                            <div class="stat-description">
                                Pendapatan transaksi selesai
                            </div>
                        </div>

                        <div class="stat-icon icon-purple">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @else

        {{-- KARTU STATISTIK PETUGAS --}}
        <div class="row g-3 mb-3">

            <div class="col-6 col-xl-6">
                <div class="dark-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stat-label">Kendaraan Sedang Parkir</div>
                            <div class="stat-number">
                                {{ number_format($jumlahMasuk, 0, ',', '.') }}
                            </div>
                            <div class="stat-description">
                                Kendaraan belum keluar
                            </div>
                        </div>

                        <div class="stat-icon icon-green">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-6">
                <div class="dark-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stat-label">Transaksi Hari Ini</div>
                            <div class="stat-number">
                                {{ number_format($transaksiHariIni ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="stat-description">
                                Aktivitas transaksi hari ini
                            </div>
                        </div>

                        <div class="stat-icon icon-blue">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endif

    {{-- RINGKASAN AKTIVITAS --}}
    @if(!$isPetugas)

        <div class="row g-3 mb-3">

            <div class="col-lg-7">

                <div class="dark-card">

                    <div class="section-title">
                        Ringkasan Aktivitas Kendaraan
                    </div>

                    <div class="section-subtitle mb-4">
                        Perbandingan kendaraan masuk dan keluar
                        berdasarkan seluruh transaksi.
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-secondary">
                            <i class="bi bi-circle-fill text-success me-1"></i>
                            Kendaraan Masuk
                        </span>

                        <strong class="text-white">
                            {{ $jumlahMasuk }}
                        </strong>
                    </div>

                    <div class="progress mb-4">
                        <div class="progress-bar bg-success"
                             style="width: {{ $persenMasuk }}%">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-secondary">
                            <i class="bi bi-circle-fill text-primary me-1"></i>
                            Kendaraan Keluar
                        </span>

                        <strong class="text-white">
                            {{ $jumlahKeluar }}
                        </strong>
                    </div>

                    <div class="progress">
                        <div class="progress-bar bg-primary"
                             style="width: {{ $persenKeluar }}%">
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top"
                         style="border-color:#29354a!important">

                        <div class="d-flex justify-content-between">
                            <span class="stat-label">
                                Total Area Parkir
                            </span>

                            <strong class="text-white">
                                {{ $area }} Area
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-5">

                <div class="dark-card">

                    <div class="section-title">
                        Menu Akses Cepat
                    </div>

                    <div class="section-subtitle mb-3">
                        Akses fitur sistem parkir
                    </div>

                    <div class="d-grid gap-2">

                        @if($role === 'admin')

                            <a href="{{ route('users.index') }}"
                               class="quick-link">
                                <i class="bi bi-people"></i>
                                <div>
                                    <strong>Manajemen Pengguna</strong>
                                    <small>Kelola akun pengguna</small>
                                </div>
                            </a>

                            <a href="{{ route('areas.index') }}"
                               class="quick-link">
                                <i class="bi bi-p-square"></i>
                                <div>
                                    <strong>Area Parkir</strong>
                                    <small>Kelola area parkir</small>
                                </div>
                            </a>

                            <a href="{{ route('tarif.index') }}"
                               class="quick-link">
                                <i class="bi bi-cash-stack"></i>
                                <div>
                                    <strong>Tarif Parkir</strong>
                                    <small>Pengaturan tarif parkir</small>
                                </div>
                            </a>

                        @elseif($role === 'owner')

                            <a href="{{ route('reports.index') }}"
                               class="quick-link">
                                <i class="bi bi-clipboard-data"></i>
                                <div>
                                    <strong>Laporan Parkir</strong>
                                    <small>Lihat laporan operasional</small>
                                </div>
                            </a>

                            <a href="{{ route('transactions.index') }}"
                               class="quick-link">
                                <i class="bi bi-receipt"></i>
                                <div>
                                    <strong>Data Transaksi</strong>
                                    <small>Lihat seluruh transaksi</small>
                                </div>
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    @else

        <div class="row g-3 mb-3">

            <div class="col-lg-6">
                <a href="{{ route('transactions.create') }}"
                   class="quick-link">
                    <i class="bi bi-plus-circle"></i>
                    <div>
                        <strong>Kendaraan Masuk</strong>
                        <small>Input kendaraan yang masuk</small>
                    </div>
                </a>
            </div>

            <div class="col-lg-6">
                <a href="{{ route('transactions.index') }}"
                   class="quick-link">
                    <i class="bi bi-receipt"></i>
                    <div>
                        <strong>Data Transaksi</strong>
                        <small>Lihat riwayat transaksi parkir</small>
                    </div>
                </a>
            </div>

        </div>

    @endif

    {{-- TABEL TRANSAKSI TERBARU --}}
    <div class="dark-card mt-3">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

            <div>
                <div class="section-title">
                    Transaksi Terbaru
                </div>

                <div class="section-subtitle">
                    Daftar aktivitas parkir terbaru
                </div>
            </div>

            <a href="{{ route('transactions.index') }}"
               class="btn-dashboard">
                Lihat Semua
                <i class="bi bi-arrow-right ms-1"></i>
            </a>

        </div>

        <div class="table-responsive">

            <table class="table dark-table align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Parkir</th>
                        <th>Nomor Polisi</th>
                        <th>Jenis Kendaraan</th>
                        <th>Area Parkir</th>
                        <th>Waktu Masuk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($transaksiTerbaru as $parkir)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong class="text-white">
                                    {{ $parkir->ticket_code }}
                                </strong>
                            </td>

                            <td>
                                {{ $parkir->plate_number }}
                            </td>

                            <td>
                                {{ $parkir->vehicle_type }}
                            </td>

                            <td>
                                {{ $parkir->parkingArea->area_name ?? '-' }}
                            </td>

                            <td>
                                {{ $parkir->entry_time
                                    ? $parkir->entry_time->format('d-m-Y H:i')
                                    : '-' }}
                            </td>

                            <td>

                                @if($parkir->status === 'masuk')

                                    <span class="badge-status badge-masuk">
                                        <i class="bi bi-circle-fill me-1"></i>
                                        Masuk
                                    </span>

                                @else

                                    <span class="badge-status badge-keluar">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Keluar
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('transactions.show', $parkir->id) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($parkir->status === 'keluar')

                                    <a href="{{ route('transactions.receipt', $parkir->id) }}"
                                       class="btn btn-sm btn-outline-success"
                                       target="_blank">
                                        <i class="bi bi-receipt"></i>
                                    </a>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="empty-data">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada transaksi parkir.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="dashboard-footer mt-4 d-flex justify-content-between flex-wrap gap-2">

        <span>
            <i class="bi bi-shield-check me-1"></i>
            Sistem Manajemen Parkir
        </span>

        <span>
            {{ now()->format('d F Y H:i') }}
        </span>

    </div>

</div>
