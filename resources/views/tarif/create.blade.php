
@extends('layouts.app')

@section('title', 'Tambah Tarif')
@section('page-title', 'Tambah Tarif Parkir')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-bold mb-4">Form Tambah Tarif</h5>

        @if($kendaraans->isEmpty())
            <div class="alert alert-warning">
                Belum ada kendaraan aktif. Tambahkan kendaraan terlebih dahulu.
            </div>
        @else

        <form action="{{ route('tarif.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Jenis Kendaraan</label>

                <select name="kendaraan_id" class="form-select" required>
                    <option value="">-- Pilih Kendaraan --</option>

                    @foreach($kendaraans as $kendaraan)
                        <option value="{{ $kendaraan->id }}"
                            {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                            {{ $kendaraan->nama_kendaraan }}
                        </option>
                    @endforeach
                </select>

                @error('kendaraan_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tarif Per Jam (Rp)</label>

                <input type="number"
                       name="tarif_per_jam"
                       class="form-control"
                       min="0"
                       step="0.01"
                       value="{{ old('tarif_per_jam') }}"
                       required>

                @error('tarif_per_jam')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tarif Maksimal (Rp)</label>

                <input type="number"
                       name="tarif_maksimal"
                       class="form-control"
                       min="0"
                       step="0.01"
                       value="{{ old('tarif_maksimal') }}">

                <small class="text-muted">
                    Kosongkan jika tidak menggunakan tarif maksimal.
                </small>

                @error('tarif_maksimal')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Tarif Menginap (Rp)</label>

                <input type="number"
                       name="tarif_menginap"
                       class="form-control"
                       min="0"
                       step="0.01"
                       value="{{ old('tarif_menginap', 0) }}"
                       required>

                @error('tarif_menginap')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Tarif
            </button>

            <a href="{{ route('tarif.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

        @endif

    </div>
</div>

@endsection
