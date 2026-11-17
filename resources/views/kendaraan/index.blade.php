
@extends('layouts.app')

@section('title', 'Data Kendaraan')
@section('page-title', 'Data Kendaraan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold">Data Kendaraan</h4>
        <p class="text-muted mb-0">Kelola jenis kendaraan parkir.</p>
    </div>

    <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kendaraan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kendaraan</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kendaraans as $kendaraan)
                    <tr>
                        <td>{{ $kendaraans->firstItem() + $loop->index }}</td>
                        <td>{{ $kendaraan->kode_kendaraan }}</td>
                        <td>{{ $kendaraan->nama_kendaraan }}</td>
                        <td>{{ $kendaraan->keterangan ?? '-' }}</td>

                        <td>
                            @if($kendaraan->status)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('kendaraan.edit', $kendaraan->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('kendaraan.destroy', $kendaraan->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">

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
                            Belum ada data kendaraan.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{ $kendaraans->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
