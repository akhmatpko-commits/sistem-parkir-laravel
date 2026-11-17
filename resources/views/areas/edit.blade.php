
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-warning">
            <h5 class="mb-0">Edit Area Parkir</h5>
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

            <form action="{{ route('areas.update', $area->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode Area</label>

                    <input type="text"
                           name="area_code"
                           class="form-control"
                           value="{{ old('area_code', $area->area_code) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Area</label>

                    <input type="text"
                           name="area_name"
                           class="form-control"
                           value="{{ old('area_name', $area->area_name) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kendaraan</label>

                    <select name="vehicle_type"
                            class="form-select"
                            required>

                        <option value="Motor"
                            @selected(old('vehicle_type', $area->vehicle_type) == 'Motor')>
                            Motor
                        </option>

                        <option value="Mobil"
                            @selected(old('vehicle_type', $area->vehicle_type) == 'Mobil')>
                            Mobil
                        </option>

                        <option value="Semua"
                            @selected(old('vehicle_type', $area->vehicle_type) == 'Semua')>
                            Semua Kendaraan
                        </option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kapasitas Parkir</label>

                    <input type="number"
                           name="capacity"
                           class="form-control"
                           min="1"
                           value="{{ old('capacity', $area->capacity) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Area</label>

                    <select name="status" class="form-select">

                        <option value="aktif"
                            @selected(old('status', $area->status) == 'aktif')>
                            Aktif
                        </option>

                        <option value="nonaktif"
                            @selected(old('status', $area->status) == 'nonaktif')>
                            Nonaktif
                        </option>

                    </select>
                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        Update Area
                    </button>

                    <a href="{{ route('areas.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
