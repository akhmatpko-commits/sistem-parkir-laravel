
@extends('layouts.app')

@section('title', 'Tarif Parkir')
@section('page-title', 'Tarif Parkir')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold">Tarif Parkir</h4>
        <p class="text-muted mb-0">Pengaturan biaya parkir kendaraan.</p>
    </div>

    <a href="{{ route('tarif.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Tarif
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>Tarif Per Jam</th>
                    <th>Tarif Maksimal</th>
                    <th>Tarif Menginap</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($tarifs as $tarif)
                    <tr>
                        <td>{{ $tarifs->firstItem() + $loop->index }}</td>

                        <td>
                            {{ $tarif->kendaraan->nama_kendaraan }}
                        </td>

                        <td>
                            Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}
                        </td>

                        <td>
                            @if($tarif->tarif_maksimal !== null)
                                Rp {{ number_format($tarif->tarif_maksimal, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            Rp {{ number_format($tarif->tarif_menginap, 0, ',', '.') }}
                        </td>

                        <td>
                            <a href="{{ route('tarif.edit', $tarif->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('tarif.destroy', $tarif->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus tarif ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada tarif parkir.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

        {{ $tarifs->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
