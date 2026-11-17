
@extends('layouts.app')

@section('title', 'Tambah Kendaraan')
@section('page-title', 'Tambah Kendaraan')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-bold mb-4">Form Tambah Kendaraan</h5>

        <form action="{{ route('kendaraan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Kendaraan</label>
                <input type="text"
                       name="nama_kendaraan"
                       class="form-control"
                       value="{{ old('nama_kendaraan') }}"
                       placeholder="Contoh: Motor"
                       required>
                @error('nama_kendaraan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Kendaraan</label>
                <input type="text"
                       name="kode_kendaraan"
                       class="form-control"
                       value="{{ old('kode_kendaraan') }}"
                       placeholder="Contoh: MTR"
                       required>
                @error('kode_kendaraan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ old('keterangan') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>

            <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection
