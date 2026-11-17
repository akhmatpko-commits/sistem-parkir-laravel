
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Data Parkir</h3>

    <a href="{{ route('parking.create') }}"
       class="btn btn-primary">
        + Kendaraan Masuk
    </a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text"
            name="search"
            class="form-control"
            placeholder="Cari nomor polisi..."
            value="{{ request('search') }}">

        <button class="btn btn-secondary">
            Cari
        </button>
    </div>
</form>

<div class="card">
    <div class="card-body table-responsive">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Tiket</th>
                    <th>Plat Nomor</th>
                    <th>Jenis</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transaksi as $item)
                    <tr>
                        <td>{{ $transaksi->firstItem() + $loop->index }}</td>
                        <td>{{ $item->ticket_code }}</td>
                        <td>{{ $item->plate_number }}</td>
                        <td>{{ $item->vehicle_type }}</td>
                        <td>{{ $item->entry_time->format('d/m/Y H:i') }}</td>

                        <td>
                            {{ $item->exit_time?->format('d/m/Y H:i') ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format($item->parking_fee, 0, ',', '.') }}
                        </td>

                        <td>
                            @if($item->status === 'masuk')
                                <span class="badge bg-warning text-dark">
                                    Masih Parkir
                                </span>
                            @else
                                <span class="badge bg-success">
                                    Sudah Keluar
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($item->status === 'masuk')
                                <form action="{{ route('parking.checkout', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Proses kendaraan keluar?')">
                                    @csrf

                                    <button class="btn btn-danger btn-sm">
                                        Check Out
                                    </button>
                                </form>
                            @else
                                <span class="text-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            Data parkir belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{ $transaksi->links() }}

    </div>
</div>

@endsection
