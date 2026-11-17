
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-4">
    <h3>Area Parkir</h3>

    <a href="{{ route('areas.create') }}"
       class="btn btn-primary">
        + Tambah Area
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="row">
    @foreach($areas as $area)

        @php
            $tersedia = max(0, $area->capacity - $area->occupied);
            $persen = $area->capacity > 0
                ? ($area->occupied / $area->capacity) * 100
                : 0;
        @endphp

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <h5>{{ $area->area_name }}</h5>

                        <span class="badge bg-primary">
                            {{ $area->area_code }}
                        </span>
                    </div>

                    <p class="text-muted mb-2">
                        Jenis: {{ $area->vehicle_type }}
                    </p>

                    <h3>{{ $area->occupied }} / {{ $area->capacity }}</h3>

                    <small>Kendaraan sedang parkir</small>

                    <div class="progress my-3">
                        <div class="progress-bar
                            {{ $persen >= 90 ? 'bg-danger' : 'bg-success' }}"
                            style="width: {{ min(100, $persen) }}%">
                        </div>
                    </div>

                    <p>
                        Slot tersedia:
                        <strong>{{ $tersedia }}</strong>
                    </p>

                    <span class="badge {{ $area->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($area->status) }}
                    </span>

                    <hr>

                    <a href="{{ route('areas.edit', $area->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    
                    <form action="{{ route('areas.destroy', $area->id) }}"
                        method="POST"
                        class="form-hapus d-inline">

                    @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">
                                 Hapus
                 </button>
                 </form>
                 
<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Hapus area parkir?',
            text: 'Data area yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>



                </div>
            </div>

        </div>

    @endforeach
</div>

{{ $areas->links() }}

@endsection
