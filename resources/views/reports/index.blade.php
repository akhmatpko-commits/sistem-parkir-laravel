
@extends('layouts.app')

@section('title', 'Laporan Parkir')
@section('page-title', 'Laporan Parkir')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold">Laporan Parkir</h3>
    <p class="text-muted">
        Lihat riwayat transaksi dan total pendapatan parkir.
    </p>
</div>

{{-- PILIHAN PERIODE CEPAT --}}

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <h6 class="fw-bold mb-3">
            <i class="bi bi-calendar-week me-2"></i>
            Pilih Periode Laporan
        </h6>

        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('reports.index', ['periode' => 'hari_ini']) }}"
               class="btn btn-sm {{ $periode === 'hari_ini' ? 'btn-primary' : 'btn-outline-primary' }}">
                Hari Ini
            </a>

            <a href="{{ route('reports.index', ['periode' => 'kemarin']) }}"
               class="btn btn-sm {{ $periode === 'kemarin' ? 'btn-primary' : 'btn-outline-primary' }}">
                Kemarin
            </a>

            <a href="{{ route('reports.index', ['periode' => '7_hari']) }}"
               class="btn btn-sm {{ $periode === '7_hari' ? 'btn-primary' : 'btn-outline-primary' }}">
                7 Hari Terakhir
            </a>

            <a href="{{ route('reports.index', ['periode' => 'bulan_ini']) }}"
               class="btn btn-sm {{ $periode === 'bulan_ini' || (!$periode && $periodeLabel === 'Bulan Ini') ? 'btn-primary' : 'btn-outline-primary' }}">
                Bulan Ini
            </a>

            <a href="{{ route('reports.index', ['periode' => 'bulan_lalu']) }}"
               class="btn btn-sm {{ $periode === 'bulan_lalu' ? 'btn-primary' : 'btn-outline-primary' }}">
                Bulan Lalu
            </a>

            <a href="{{ route('reports.index', ['periode' => 'semua']) }}"
               class="btn btn-sm {{ $periode === 'semua' ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua Data
            </a>

        </div>

    </div>
</div>

{{-- FILTER TANGGAL MANUAL --}}

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <h6 class="fw-bold mb-3">
            <i class="bi bi-calendar-range me-2"></i>
            Filter Berdasarkan Tanggal
        </h6>

        <form method="GET" action="{{ route('reports.index') }}">

            <div class="row g-3">

                <div class="col-md-4">

                    <label class="form-label">
                        Tanggal Mulai
                    </label>

                    <input type="date"
                           name="tanggal_mulai"
                           class="form-control"
                           value="{{ $tanggalMulai }}"
                           max="{{ $tanggalSelesai }}">

                    @error('tanggal_mulai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Tanggal Selesai
                    </label>

                    <input type="date"
                           name="tanggal_selesai"
                           class="form-control"
                           value="{{ $tanggalSelesai }}"
                           min="{{ $tanggalMulai }}">

                    @error('tanggal_selesai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Tampilkan Laporan
                    </button>

                    <a href="{{ route('reports.index') }}"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset
                    </a>

                </div>

            </div>

        </form>

        @error('periode')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror

    </div>
</div>

{{-- RINGKASAN PENDAPATAN --}}

<div class="row g-3 mb-3">

    <div class="col-md-6">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <p class="text-muted mb-2">
                    Total Pendapatan
                </p>

                <h3 class="fw-bold text-success mb-0">
                    Rp {{ number_format($pendapatan, 0, ',', '.') }}
                </h3>

                <small class="text-muted">
                    Periode: {{ $periodeLabel }}
                </small>

            </div>
        </div>

    </div>

    <div class="col-md-6">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <p class="text-muted mb-2">
                    Jumlah Transaksi
                </p>

                <h3 class="fw-bold mb-0">
                    {{ $transaksi->total() }}
                </h3>

                <small class="text-muted">
                    Kendaraan sudah keluar
                </small>

            </div>
        </div>

    </div>

</div>

{{-- TABEL LAPORAN --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <h5 class="fw-bold mb-0">
            <i class="bi bi-table me-2"></i>
            Data Laporan Parkir
        </h5>

    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>Tiket</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Kendaraan</th>
                    <th>Waktu Keluar</th>
                    <th>Biaya</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transaksi as $item)

                    <tr>

                        <td>
                            {{ $item->ticket_code }}
                        </td>

                        <td class="fw-bold">
                            {{ $item->plate_number }}
                        </td>

                        <td>
                            {{ $item->vehicle_type }}
                        </td>

                        <td>
                            {{ $item->exit_time?->format('d/m/Y H:i') ?? '-' }}
                        </td>

                        <td class="fw-bold">
                            Rp {{ number_format($item->parking_fee, 0, ',', '.') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5"
                            class="text-center text-muted py-4">

                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                            Belum ada laporan pada periode ini.

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-3">
            {{ $transaksi->links() }}
        </div>

    </div>

</div>

@endsection
