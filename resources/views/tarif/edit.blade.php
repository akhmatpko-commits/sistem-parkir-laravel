
@extends('layouts.app')

@section('title', 'Edit Tarif')
@section('page-title', 'Edit Tarif Parkir')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-bold mb-4">Form Edit Tarif</h5>

        <form action="{{ route('tarif.update', $tarif->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Jenis Kendaraan</label>

                <select name="kendaraan_id" class="form-select" required>

                    @foreach($kendaraans as $kendaraan)
                        <option value="{{ $kendaraan->id }}"
                            {{ old('kendaraan_id', $tarif->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>
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
                       value="{{ old('tarif_per_jam', $tarif->tarif_per_jam) }}"
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
                       value="{{ old('tarif_maksimal', $tarif->tarif_maksimal) }}">

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
                       value="{{ old('tarif_menginap', $tarif->tarif_menginap) }}"
                       required>

                @error('tarif_menginap')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Update Tarif
            </button>

            <a href="{{ route('tarif.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
