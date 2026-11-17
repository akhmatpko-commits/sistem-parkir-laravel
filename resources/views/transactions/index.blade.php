
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Parkir</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 25px;
            color: #1e293b;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h2 { margin: 0 0 8px; }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 7px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .blue { background: #2563eb; }
        .green { background: #16a34a; }
        .red { background: #dc2626; }
        .gray { background: #64748b; }
        .dark { background: #475569; }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #0000000d;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            font-size: 13px;
        }

        th {
            background: #f8fafc;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .masuk {
            background: #dcfce7;
            color: #166534;
        }

        .keluar {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .alert {
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 15px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination {
            margin-top: 20px;
        }

        .header-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h2>🚗 Data Transaksi Parkir</h2>
            <p>Kelola kendaraan masuk dan keluar.</p>
        </div>

        <div class="header-buttons">

            {{-- TOMBOL KEMBALI KE DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="btn dark">
                ← Kembali ke Dashboard
            </a>

            {{-- TOMBOL KENDARAAN MASUK --}}
            <a href="{{ route('transactions.create') }}"
               class="btn blue">
                + Kendaraan Masuk
            </a>

        </div>
    </div>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Tiket</th>
                    <th>Nomor Polisi</th>
                    <th>Jenis Kendaraan</th>
                    <th>Area Parkir</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transactions as $transaction)

                <tr>
                    <td>{{ $transactions->firstItem() + $loop->index }}</td>

                    <td>
                        {{ $transaction->ticket_code }}
                    </td>

                    <td>
                        <strong>{{ $transaction->plate_number }}</strong>
                    </td>

                    <td>{{ $transaction->vehicle_type }}</td>

                    <td>
                        {{ $transaction->parkingArea->area_name ?? '-' }}
                    </td>

                    <td>
                        {{ $transaction->entry_time
                            ? $transaction->entry_time->format('d-m-Y H:i')
                            : '-' }}
                    </td>

                    <td>
                        {{ $transaction->exit_time
                            ? $transaction->exit_time->format('d-m-Y H:i')
                            : '-' }}
                    </td>

                    <td>
                        Rp {{ number_format($transaction->parking_fee, 0, ',', '.') }}
                    </td>

                    <td>
                        @if($transaction->status == 'masuk')
                            <span class="badge masuk">Masih Parkir</span>
                        @else
                            <span class="badge keluar">Sudah Keluar</span>
                        @endif
                    </td>

                    <td>
                        <div class="actions">

                            <a href="{{ route('transactions.show', $transaction->id) }}"
                               class="btn gray">
                                Detail
                            </a>

                            @if($transaction->status == 'masuk')
                                <a href="{{ route('transactions.checkout', $transaction->id) }}"
                                   class="btn green">
                                    Checkout
                                </a>
                            @endif

                            @if($transaction->status == 'keluar')
                                <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn red">
                                        Hapus
                                    </button>
                                </form>
                            @endif

                        </div>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="10" style="text-align:center;padding:30px;">
                        Belum ada transaksi parkir.
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>

        <div class="pagination">
            {{ $transactions->links() }}
        </div>

    </div>

</div>

</body>
</html>
