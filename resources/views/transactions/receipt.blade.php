
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Parkir</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }

        .receipt {
            max-width: 420px;
            margin: auto;
            padding: 25px;
            background: white;
            border: 1px solid #ddd;
        }

        h2, p.center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #555;
            margin: 15px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin: 10px 0;
        }

        .item span:last-child {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
        }

        .actions {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt {
                border: none;
            }

            .actions {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="receipt">

    <h2>STRUK PARKIR</h2>
    <p class="center">Bukti Pembayaran Parkir</p>

    <div class="line"></div>

    <div class="item">
        <span>Nomor Tiket</span>
        <span>{{ $transaction->ticket_code }}</span>
    </div>

    <div class="item">
        <span>Plat Nomor</span>
        <span>{{ $transaction->plate_number }}</span>
    </div>

    <div class="item">
        <span>Jenis Kendaraan</span>
        <span>{{ $transaction->vehicle_type }}</span>
    </div>

    <div class="item">
        <span>Area Parkir</span>
        <span>{{ $transaction->parkingArea->area_name ?? '-' }}</span>
    </div>

    <div class="line"></div>

    <div class="item">
        <span>Waktu Masuk</span>
        <span>{{ $transaction->entry_time->format('d-m-Y H:i') }}</span>
    </div>

    <div class="item">
        <span>Waktu Keluar</span>
        <span>{{ $transaction->exit_time->format('d-m-Y H:i') }}</span>
    </div>

    <div class="line"></div>

    <div class="item total">
        <span>Total Biaya</span>
        <span>Rp{{ number_format($transaction->payment->amount, 0, ',', '.') }}</span>
    </div>

    <div class="item">
        <span>Uang Dibayarkan</span>
        <span>Rp{{ number_format($transaction->payment->amount_received, 0, ',', '.') }}</span>
    </div>

    <div class="item">
        <span>Kembalian</span>
        <span>Rp{{ number_format($transaction->payment->change_amount, 0, ',', '.') }}</span>
    </div>

    <div class="item">
        <span>Metode Pembayaran</span>
        <span>{{ strtoupper($transaction->payment->method) }}</span>
    </div>

    <div class="item">
        <span>Waktu Pembayaran</span>
        <span>{{ $transaction->payment->paid_at->format('d-m-Y H:i') }}</span>
    </div>

    <div class="line"></div>

    <p class="center">
        Terima kasih telah menggunakan layanan parkir kami.
    </p>

    <div class="actions">
        <button onclick="window.print()">Cetak Struk</button>
        <button onclick="window.location.href='{{ route('transactions.index') }}'">
            Kembali
        </button>
    </div>

</div>

</body>
</html>
