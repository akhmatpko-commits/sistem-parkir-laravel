@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

    <div>
        <h4 class="fw-bold">Selamat Datang, Admin!</h4>
        <p class="text-muted">
            Berikut ringkasan sistem parkir Anda.
        </p>
    </div>

    <a href="{{ route('transactions.create') }}"
       class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>
        Kendaraan Masuk
    </a>

</div>

{{-- STATISTIK --}}

<div class="row g-3">

    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-2">Total Kendaraan</p>
                    <h3 class="fw-bold">
                        {{ $totalKendaraan }}
                    </h3>
                </div>

                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-car-front"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-2">Kendaraan Masuk</p>
                    <h3 class="fw-bold">
                        {{ $kendaraanMasuk }}
                    </h3>
                </div>

                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-2">Kendaraan Keluar</p>
                    <h3 class="fw-bold">
                        {{ $kendaraanKeluar }}
                    </h3>
                </div>

                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-2">Total Pendapatan</p>
                    <h4 class="fw-bold">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h4>
                </div>

                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MENU CEPAT --}}

<div class="row g-3 mt-3">

    <div class="col-md-4">
        <a href="{{ route('transactions.create') }}"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">

                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold text-dark mb-1">
                            Kendaraan Masuk
                        </h6>
                        <small class="text-muted">
                            Input kendaraan masuk
                        </small>
                    </div>

                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('transactions.index') }}"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">

                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold text-dark mb-1">
                            Data Transaksi
                        </h6>
                        <small class="text-muted">
                            Lihat semua transaksi
                        </small>
                    </div>

                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('areas.index') }}"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">

                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-p-square-fill"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold text-dark mb-1">
                            Area Parkir
                        </h6>
                        <small class="text-muted">
                            Kelola area parkir
                        </small>
                    </div>

                </div>
            </div>
        </a>
    </div>

</div>

{{-- TRANSAKSI TERBARU --}}

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">

        <h5 class="mb-0 fw-bold">
            Transaksi Terbaru
        </h5>

        <a href="{{ route('transactions.index') }}"
           class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>

    </div>

    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">

        <thead>
    <tr>
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

                        <td>
                            {{ $parkir->ticket_code }}
                        </td>

                        <td class="fw-bold">
                            {{ $parkir->plate_number }}
                        </td>

                        <td>
                            {{ $parkir->vehicle_type }}
                        </td>

                        <td>
                            {{ $parkir->parkingArea->area_name ?? '-' }}
                        </td>

                        <td>
                            {{ $parkir->entry_time?->format('d-m-Y H:i') ?? '-' }}
                        </td>

                        <td>
                        <td>
    @if($parkir->status === 'keluar' && $parkir->payment)
        <a href="{{ route('transactions.receipt', $parkir->id) }}"
           class="btn btn-success btn-sm"
           target="_blank">
            <i class="bi bi-receipt"></i>
            Lihat Struk
        </a>
    @else
        <span class="text-muted">
            Belum tersedia
        </span>
    @endif
</td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7"
                            class="text-center text-muted py-4">

                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                            Belum ada transaksi parkir.

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
