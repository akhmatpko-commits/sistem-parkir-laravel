
@extends('layouts.app')

@section('content')

<h3 class="mb-4">Dashboard Parkir</h3>

{{-- RINGKASAN DASHBOARD --}}
<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Kendaraan</h6>
                <h2>{{ $totalKendaraan }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-warning">
            <div class="card-body">
                <h6>Kendaraan Masuk</h6>
                <h2>{{ $kendaraanMasuk }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Kendaraan Keluar</h6>
                <h2>{{ $kendaraanKeluar }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h6>Total Pendapatan</h6>
                <h4>Rp {{ number_format($pendapatan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

</div>

{{-- TABEL TRANSAKSI TERBARU --}}
<div class="card mt-3">

    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Transaksi Terbaru</strong>

        <a href="{{ route('transactions.index') }}"
           class="btn btn-primary btn-sm">
            Semua Transaksi
        </a>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-striped">

            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tiket</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Kendaraan</th>
                    <th>Waktu Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transaksi as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->ticket_code }}</td>

                        <td>{{ $item->plate_number }}</td>

                        <td>{{ $item->vehicle_type }}</td>

                        <td>
                            {{ $item->entry_time->format('d-m-Y H:i') }}
                        </td>

                        <td>
                            @if($item->status === 'masuk')
                                <span class="badge bg-warning text-dark">
                                    Masuk
                                </span>
                            @else
                                <span class="badge bg-success">
                                    Keluar
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($item->status === 'keluar')

                                <a href="{{ route('transactions.receipt', $item->id) }}"
                                   class="btn btn-success btn-sm"
                                   target="_blank">
                                    Lihat Struk
                                </a>

                            @else

                                <span class="text-muted">
                                    Belum dibayar
                                </span>

                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada transaksi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection
