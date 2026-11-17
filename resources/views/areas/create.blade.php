
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Area Parkir</h5>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('areas.store') }}"
                  method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Kode Area</label>

                    <input type="text"
                           name="area_code"
                           class="form-control"
                           placeholder="Contoh: A001"
                           value="{{ old('area_code') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Area</label>

                    <input type="text"
                           name="area_name"
                           class="form-control"
                           placeholder="Contoh: Area Motor A"
                           value="{{ old('area_name') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kendaraan</label>

                    <select name="vehicle_type"
                            class="form-select"
                            required>

                        <option value="">-- Pilih Kendaraan --</option>
                        <option value="Motor">Motor</option>
                        <option value="Mobil">Mobil</option>
                        <option value="Semua">Semua</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kapasitas Parkir</label>

                    <input type="number"
                           name="capacity"
                           class="form-control"
                           min="1"
                           placeholder="Contoh: 50"
                           value="{{ old('capacity') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Area</label>

                    <select name="status" class="form-select">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Area
                    </button>

                    <a href="{{ route('areas.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    
                    @if($errors->any())
                <div class="alert alert-danger">
                        <strong>Periksa kembali input kamu!</strong>

                        <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                </div>

            </form>

        </div>
    </div>

</div>

@endsection
