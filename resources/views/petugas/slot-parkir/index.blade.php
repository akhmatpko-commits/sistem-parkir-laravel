
@extends('layouts.app')

@section('title', 'Slot Parkir')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Slot Parkir</h3>
            <p class="text-muted mb-0">
                Informasi kapasitas dan ketersediaan slot parkir
            </p>
        </div>
    </div>

    {{-- RINGKASAN SLOT --}}
    @php
        $totalArea = $areas->count();
        $totalKapasitas = $areas->sum('capacity');
        $totalTerisi = $areas->sum('terisi');
        $totalTersedia = $areas->sum('tersedia');
    @endphp

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Kapasitas</p>
                    <h2 class="fw-bold mb-0">
                        {{ $totalKapasitas }}
                    </h2>
                    <small class="text-muted">
                        {{ $totalArea }} area parkir aktif
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Slot Terisi</p>
                    <h2 class="fw-bold text-danger mb-0">
                        {{ $totalTerisi }}
                    </h2>
                    <small class="text-muted">
                        Kendaraan sedang parkir
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Slot Tersedia</p>
                    <h2 class="fw-bold text-success mb-0">
                        {{ $totalTersedia }}
                    </h2>
                    <small class="text-muted">
                        Slot yang masih kosong
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- TABEL SLOT PARKIR --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Daftar Slot Parkir</h5>
        </div>

        <div class="card-body">

            @if($areas->isEmpty())

                <div class="text-center py-5">
                    <h5 class="text-muted">
                        Belum ada area parkir aktif
                    </h5>
                    <p class="text-muted mb-0">
                        Silakan hubungi Admin untuk informasi area parkir.
                    </p>
                </div>

            @else

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Area</th>
                                <th>Jenis Kendaraan</th>
                                <th>Kapasitas</th>
                                <th>Terisi</th>
                                <th>Tersedia</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($areas as $index => $area)

                                @php
                                    $persentase = $area->capacity > 0
                                        ? ($area->terisi / $area->capacity) * 100
                                        : 0;
                                @endphp

                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td class="fw-semibold">
                                        {{ $area->area_name }}
                                    </td>

                                    <td>
                                        {{ $area->vehicle_type }}
                                    </td>

                                    <td>
                                        {{ $area->capacity }}
                                    </td>

                                    <td class="text-danger fw-semibold">
                                        {{ $area->terisi }}
                                    </td>

                                    <td class="text-success fw-semibold">
                                        {{ $area->tersedia }}
                                    </td>

                                    <td>
                                        @if($area->tersedia <= 0)
                                            <span class="badge bg-danger">
                                                Penuh
                                            </span>
                                        @elseif($persentase >= 80)
                                            <span class="badge bg-warning text-dark">
                                                Hampir Penuh
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                Tersedia
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

        </div>
    </div>

    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle me-2"></i>
        Halaman ini hanya untuk melihat informasi slot parkir.
        Petugas tidak dapat menambah, mengedit, atau menghapus area parkir.
    </div>

</div>
@endsection
