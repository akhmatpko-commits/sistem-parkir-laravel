
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pembayaran Parkir</h3>

    <div class="card p-4">
        <p>
            <strong>Kode Tiket:</strong>
            {{ $transaction->ticket_code }}
        </p>

        <p>
            <strong>Nomor Polisi:</strong>
            {{ $transaction->plate_number }}
        </p>

        <p>
            <strong>Jenis Kendaraan:</strong>
            {{ $transaction->vehicle_type }}
        </p>

        <p>
            <strong>Waktu Masuk:</strong>
            {{ $transaction->entry_time->format('d-m-Y H:i:s') }}
        </p>

        <h4>
            Total Biaya:
            Rp {{ number_format($estimatedFee, 0, ',', '.') }}
        </h4>

        <form action="{{ route('transactions.processCheckout', $transaction->id) }}"
              method="POST">
            @csrf

            <div class="mb-3">
                <label>Uang Diterima</label>
                <input
                    type="number"
                    name="amount_received"
                    class="form-control"
                    min="{{ $estimatedFee }}"
                    step="0.01"
                    value="{{ old('amount_received') }}"
                    required
                >

                @error('amount_received')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Metode Pembayaran</label>
                <select name="method" class="form-control" required>
                    <option value="tunai">Tunai</option>
                    <option value="non_tunai">Non Tunai</option>
                </select>
            </div>

            @error('transaction')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-success">
                Proses Pembayaran dan Kendaraan Keluar
            </button>

            <a href="{{ route('transactions.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection
