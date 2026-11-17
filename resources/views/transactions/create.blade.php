
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan Masuk - Parkir App</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000012;
        }

        h2 {
            color: #1e293b;
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #2563eb;
            text-decoration: none;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('transactions.index') }}" class="back">
        ← Kembali ke Transaksi
    </a>

    <h2>🚗 Kendaraan Masuk</h2>

    <p>Silakan isi data kendaraan yang akan parkir.</p>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">

        @csrf

        <label>Nomor Polisi</label>
        <input
            type="text"
            name="plate_number"
            placeholder="Contoh: N 1234 AB"
            value="{{ old('plate_number') }}"
            required
        >

        @error('plate_number')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Jenis Kendaraan</label>
        <select name="vehicle_type" required>
            <option value="">-- Pilih Kendaraan --</option>
            <option value="Motor" {{ old('vehicle_type') == 'Motor' ? 'selected' : '' }}>Motor</option>
            <option value="Mobil" {{ old('vehicle_type') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
        </select>

        @error('vehicle_type')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Area Parkir</label>
        <select name="parking_area_id" required>
            <option value="">-- Pilih Area Parkir --</option>

            @foreach($areas as $area)
                <option value="{{ $area->id }}"
                    {{ old('parking_area_id') == $area->id ? 'selected' : '' }}>

                    {{ $area->area_name }}
                    ({{ $area->area_code }})
                    - Sisa {{ $area->available }} tempat

                </option>
            @endforeach

        </select>

        @error('parking_area_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">
            Simpan Kendaraan Masuk
        </button>

    </form>

</div>

</body>
</html>
