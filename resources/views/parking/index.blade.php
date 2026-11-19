
@extends('layouts.app')

@section('title', request()->routeIs('parking.keluar')
    ? 'Data Kendaraan Keluar'
    : 'Kendaraan Keluar')

@section('page-title', request()->routeIs('parking.keluar')
    ? 'Data Kendaraan Keluar'
    : 'Kendaraan Keluar')

@section('content')

@php
    $riwayatKeluar = request()->routeIs('parking.keluar');
@endphp

{{-- JUDUL DAN TOMBOL --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

    <div>
        <h3 class="fw-bold">
            {{ $riwayatKeluar ? 'Data Kendaraan Keluar' : 'Kendaraan Masih Parkir' }}
        </h3>

        <p class="text-muted mb-0">
            @if($riwayatKeluar)
                Daftar kendaraan yang sudah selesai melakukan checkout.
            @else
                Daftar kendaraan yang masih berada di area parkir.
            @endif
        </p>
    </div>

    @if(!$riwayatKeluar)
        <a href="{{ route('transactions.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Kendaraan Masuk
        </a>
    @endif

</div>

{{-- PENCARIAN --}}
<form method="GET"
      action="{{ $riwayatKeluar ? route('parking.keluar') : route('parking.index') }}"
      class="mb-3">

    <div class="input-group">

        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari nomor polisi..."
               value="{{ request('search') }}">

        <button type="submit" class="btn btn-secondary">
            <i class="bi bi-search"></i>
            Cari
        </button>

        @if(request('search'))
            <a href="{{ $riwayatKeluar ? route('parking.keluar') : route('parking.index') }}"
               class="btn btn-outline-secondary">
                Reset
            </a>
        @endif

    </div>

</form>

{{-- TABEL DATA --}}
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Tiket</th>
                        <th>Plat Nomor</th>
                        <th>Jenis</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($transaksi as $item)

                        <tr>

                            <td>
                                {{ $transaksi->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $item->ticket_code }}
                            </td>

                            <td>
                                <strong>
                                    {{ $item->plate_number }}
                                </strong>
                            </td>

                            <td>
                                {{ $item->vehicle_type }}
                            </td>

                            <td>
                                {{ $item->entry_time
                                    ? $item->entry_time->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $item->exit_time
                                    ? $item->exit_time->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($item->parking_fee, 0, ',', '.') }}
                            </td>

                            <td>

                                @if($item->status === 'masuk')

                                    <span class="badge bg-warning text-dark">
                                        Masih Parkir
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Sudah Keluar
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($item->status === 'masuk')

                                    {{-- PROSES CHECKOUT --}}
                                    <form action="{{ route('parking.checkout', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Proses kendaraan keluar?')">

                                        @csrf

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">

                                            <i class="bi bi-box-arrow-right"></i>
                                            Check Out

                                        </button>

                                    </form>

                                @else

                                    {{-- LIHAT STRUK --}}
                                    @if($item->payment)

                                        <a href="{{ route('transactions.receipt', $item->id) }}"
                                           class="btn btn-primary btn-sm">

                                            <i class="bi bi-receipt"></i>
                                            Lihat Struk

                                        </a>

                                    @else

                                        <span class="badge bg-secondary">
                                            Belum Dibayar
                                        </span>

                                    @endif

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-center py-4">

                                @if($riwayatKeluar)

                                    <i class="bi bi-car-front fs-2 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada data kendaraan keluar.
                                    </p>

                                @else

                                    <i class="bi bi-car-front fs-2 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Tidak ada kendaraan yang sedang parkir.
                                    </p>

                                @endif

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        {{ $transaksi->withQueryString()->links() }}

    </div>

</div>

@endsection
