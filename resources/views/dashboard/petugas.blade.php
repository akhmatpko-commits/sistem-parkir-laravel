
@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('page-title', 'Dashboard Petugas')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold">Selamat Bekerja, Petugas!</h4>
    <p class="text-muted">
        Kelola aktivitas kendaraan masuk dan keluar.
    </p>
</div>

{{-- INFORMASI DASHBOARD --}}
<div class="row g-3">

    <div class="col-md-4">
        <div class="stat-card">
            <p class="text-muted">Kendaraan Sedang Parkir</p>
            <h2 class="fw-bold">{{ $kendaraanMasuk }}</h2>
            <div class="stat-icon bg-success-subtle text-success">
                <i class="bi bi-car-front"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <p class="text-muted">Transaksi Hari Ini</p>
            <h2 class="fw-bold">{{ $transaksiHariIni }}</h2>
            <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-receipt"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <p class="text-muted">Kendaraan Keluar</p>
            <h2 class="fw-bold">
                {{ \App\Models\ParkingTransaction::where('status', 'keluar')->whereDate('exit_time', today())->count() }}
            </h2>
            <div class="stat-icon bg-warning-subtle text-warning">
                <i class="bi bi-car-front-fill"></i>
            </div>
        </div>
    </div>

</div>

{{-- MENU OPERASIONAL --}}
<div class="card border-0 shadow-sm mt-4">

    <div class="card-body">

        <h5 class="fw-bold mb-3">Menu Operasional Petugas</h5>

        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('transactions.create') }}"
               class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Kendaraan Masuk
            </a>

            <a href="{{ route('transactions.index') }}"
               class="btn btn-success">
                <i class="bi bi-box-arrow-right"></i>
                Kendaraan Keluar
            </a>

        </div>

    </div>

</div>

{{-- DAFTAR TRANSAKSI TERBARU --}}
<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            Transaksi Kendaraan Terbaru
        </h5>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">

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

                            <td>
                                <strong>
                                    {{ $parkir->plate_number }}
                                </strong>
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

                                    <span class="badge bg-success">
                                        Masih Parkir
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Sudah Keluar
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($parkir->status === 'masuk')

                                    <a href="{{ route('transactions.checkout', $parkir->id) }}"
                                       class="btn btn-sm btn-success">

                                        <i class="bi bi-box-arrow-right"></i>
                                        Kendaraan Keluar

                                    </a>

                                @else

                                    <a href="{{ route('transactions.receipt', $parkir->id) }}"
                                       class="btn btn-sm btn-primary">

                                        <i class="bi bi-receipt"></i>
                                        Lihat Struk

                                    </a>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="text-center text-muted py-4">
                                Belum ada transaksi parkir.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
