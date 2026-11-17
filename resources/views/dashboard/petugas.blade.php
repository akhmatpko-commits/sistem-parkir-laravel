
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

<div class="row g-3">

    <div class="col-md-6">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <p class="text-muted">
                        Kendaraan Sedang Parkir
                    </p>

                    <h2 class="fw-bold">
                        {{ $kendaraanMasuk }}
                    </h2>

                </div>

                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-car-front"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <p class="text-muted">
                        Transaksi Hari Ini
                    </p>

                    <h2 class="fw-bold">
                        {{ $transaksiHariIni }}
                    </h2>

                </div>

                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-receipt"></i>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white py-3">

        <h5 class="fw-bold mb-0">
            Transaksi Terbaru
        </h5>

    </div>

    <div class="card-body">

        <a href="{{ route('transactions.create') }}"
           class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i>
            Kendaraan Masuk
        </a>

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
                                        Masuk
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Keluar
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted">
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
