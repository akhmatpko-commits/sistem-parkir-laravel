<?php

namespace App\Http\Controllers;

use App\Models\ParkingTransaction;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    // DAFTAR KENDARAAN YANG SEDANG PARKIR
    public function index(Request $request)
    {
        $query = ParkingTransaction::with('parkingArea')
            ->where('status', 'masuk');

        if ($request->filled('search')) {
            $query->where(
                'plate_number',
                'like',
                '%' . $request->search . '%'
            );
        }

        $transaksi = $query->latest()->paginate(10);

        return view('parking.index', compact('transaksi'));
    }

    // DAFTAR KENDARAAN YANG SUDAH KELUAR
    public function keluar(Request $request)
    {
        $query = ParkingTransaction::with([
            'parkingArea',
            'payment'
        ])
        ->where('status', 'keluar');

        if ($request->filled('search')) {
            $query->where(
                'plate_number',
                'like',
                '%' . $request->search . '%'
            );
        }

        $transaksi = $query->latest()->paginate(10);

        return view('parking.index', compact('transaksi'));
    }

    // FORM KENDARAAN MASUK
    public function create()
    {
        return redirect()->route('transactions.create');
    }

    // SIMPAN KENDARAAN MASUK
    public function store(Request $request)
    {
        return app(ParkingTransactionController::class)
            ->store($request);
    }

    // KENDARAAN KELUAR
    public function checkout($id)
    {
        $transaksi = ParkingTransaction::findOrFail($id);

        if ($transaksi->status !== 'masuk') {
            return back()->with(
                'error',
                'Kendaraan sudah keluar.'
            );
        }

        return redirect()->route(
            'transactions.checkout',
            $transaksi->id
        );
    }
}
