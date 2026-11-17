
@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Kendaraan Masuk</h4>
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

        <form action="{{ route('parking.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nomor Polisi</label>

                <input type="text"
                    name="plate_number"
                    class="form-control"
                    placeholder="Contoh: N 1234 ABC"
                    value="{{ old('plate_number') }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Jenis Kendaraan</label>

                <select name="vehicle_type" class="form-select" required>
                    <option value="">-- Pilih Kendaraan --</option>
                    <option value="Motor">Motor</option>
                    <option value="Mobil">Mobil</option>
                </select>
            </div>

            <button class="btn btn-primary">
                Simpan Kendaraan
            </button>

            <a href="{{ route('parking.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
