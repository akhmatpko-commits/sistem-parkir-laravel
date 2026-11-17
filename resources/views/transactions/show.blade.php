
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi Parkir</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 25px;
            margin: 0;
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 15px #00000012;
        }

        h2 {
            margin-top: 0;
            color: #1e293b;
        }

        .item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 14px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .item span {
            color: #64748b;
        }

        .item strong {
            text-align: right;
        }

        .badge {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .masuk {
            background: #dcfce7;
            color: #166534;
        }

        .keluar {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 7px;
            margin-top: 20px;
        }

        .fee {
            color: #16a34a;
            font-size: 22px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h2>📋 Detail Transaksi Parkir</h2>

        <p>Informasi lengkap kendaraan.</p>

        <div class="item">
            <span>Kode Tiket</span>
            <strong>{{ $transaction->ticket_code }}</strong>
        </div>

        <div class="item">
            <span>Nomor Polisi</span>
            <strong>{{ $transaction->plate_number }}</strong>
        </div>

        <div class="item">
            <span>Jenis Kendaraan</span>
            <strong>{{ $transaction->vehicle_type }}</strong>
        </div>

        <div class="item">
            <span>Area Parkir</span>
            <strong>{{ $transaction->parkingArea->area_name ?? '-' }}</strong>
        </div>

        <div class="item">
            <span>Kode Area</span>
            <strong>{{ $transaction->parkingArea->area_code ?? '-' }}</strong>
        </div>

        <div class="item">
            <span>Petugas</span>
            <strong>{{ $transaction->user->name ?? '-' }}</strong>
        </div>

        <div class="item">
            <span>Waktu Masuk</span>
            <strong>
                {{ $transaction->entry_time
                    ? $transaction->entry_time->format('d-m-Y H:i:s')
                    : '-' }}
            </strong>
        </div>

        <div class="item">
            <span>Waktu Keluar</span>
            <strong>
                {{ $transaction->exit_time
                    ? $transaction->exit_time->format('d-m-Y H:i:s')
                    : '-' }}
            </strong>
        </div>

        <div class="item">
            <span>Status</span>

            @if($transaction->status == 'masuk')
                <strong class="badge masuk">Masih Parkir</strong>
            @else
                <strong class="badge keluar">Sudah Keluar</strong>
            @endif
        </div>

        <div class="item">
            <span>Total Biaya</span>

            <strong class="fee">
                Rp {{ number_format($transaction->parking_fee, 0, ',', '.') }}
            </strong>
        </div>

        <div class="d-flex gap-2 flex-wrap">

    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('transactions.index') }}"
       class="btn btn-primary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    {{-- TOMBOL CETAK STRUK --}}
    @if($transaction->status === 'keluar' && $transaction->payment)
        <a href="{{ route('transactions.receipt', $transaction->id) }}"
           class="btn btn-success"
           target="_blank">
            <i class="bi bi-printer"></i>
            Cetak Struk
        </a>
    @endif

</div>

</div>

</body>
</html>
