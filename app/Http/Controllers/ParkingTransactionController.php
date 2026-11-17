<?php

namespace App\Http\Controllers;

use App\Models\ParkingArea;
use App\Models\ParkingPayment;
use App\Models\ParkingTransaction;
use App\Models\Tariff;
use App\Models\User;
use App\Notifications\TransaksiParkirNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ParkingTransactionController extends Controller
{
    // DAFTAR TRANSAKSI
    public function index()
    {
        $transactions = ParkingTransaction::with([
            'parkingArea',
            'user',
            'payment'
        ])
        ->latest()
        ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    // FORM KENDARAAN MASUK
    public function create()
    {
        $areas = ParkingArea::where('status', 'aktif')
            ->orderBy('area_name')
            ->get();

        return view('transactions.create', compact('areas'));
    }

    // PROSES KENDARAAN MASUK
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parking_area_id' => 'required|exists:parking_areas,id',
            'plate_number' => 'required|string|max:20',
            'vehicle_type' => 'required|in:Motor,Mobil',
        ]);

        $plateNumber = strtoupper(trim($validated['plate_number']));

        DB::transaction(function () use ($validated, $plateNumber) {

            $area = ParkingArea::whereKey($validated['parking_area_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($area->status !== 'aktif') {
                throw ValidationException::withMessages([
                    'parking_area_id' => 'Area parkir tidak aktif.',
                ]);
            }

            if (
                $area->vehicle_type !== 'Semua' &&
                $area->vehicle_type !== $validated['vehicle_type']
            ) {
                throw ValidationException::withMessages([
                    'vehicle_type' => 'Jenis kendaraan tidak sesuai dengan area.',
                ]);
            }

            // PERIKSA KENDARAAN YANG MASIH PARKIR
            $existingVehicle = ParkingTransaction::where(
                'plate_number',
                $plateNumber
            )
            ->where('status', 'masuk')
            ->exists();

            if ($existingVehicle) {
                throw ValidationException::withMessages([
                    'plate_number' => 'Kendaraan masih berada di area parkir.',
                ]);
            }

            // HITUNG KAPASITAS AREA
            $occupied = ParkingTransaction::where(
                'parking_area_id',
                $area->id
            )
            ->where('status', 'masuk')
            ->count();

            if ($occupied >= $area->capacity) {
                throw ValidationException::withMessages([
                    'parking_area_id' => 'Area parkir sudah penuh!',
                ]);
            }

            // SIMPAN TRANSAKSI KENDARAAN MASUK
            ParkingTransaction::create([
                'parking_area_id' => $area->id,
                'ticket_code' => 'PKR-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5)),
                'plate_number' => $plateNumber,
                'vehicle_type' => $validated['vehicle_type'],
                'entry_time' => now(),
                'exit_time' => null,
                'parking_fee' => 0,
                'status' => 'masuk',
                'user_id' => auth()->id(),
            ]);
        });

        // NOTIFIKASI KENDARAAN MASUK
        $this->kirimNotifikasiTransaksi(
            'Kendaraan Masuk',
            'Kendaraan dengan plat nomor ' . $plateNumber . ' berhasil masuk area parkir.'
        );

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Kendaraan berhasil masuk!');
    }

    // DETAIL TRANSAKSI
    public function show(ParkingTransaction $transaction)
    {
        $transaction->load([
            'parkingArea',
            'user',
            'payment'
        ]);

        return view('transactions.show', compact('transaction'));
    }

    // FORM CHECKOUT / PEMBAYARAN
    public function checkout(ParkingTransaction $transaction)
    {
        // CEK APAKAH PEMBAYARAN SUDAH ADA
        if ($transaction->payment()->exists()) {
            return redirect()
                ->route('transactions.receipt', $transaction->id);
        }

        // JIKA KENDARAAN SUDAH KELUAR TETAPI BELUM DIBAYAR
        if ($transaction->status === 'keluar') {
            $estimatedFee = (float) $transaction->parking_fee;

            return view('transactions.checkout', compact(
                'transaction',
                'estimatedFee'
            ));
        }

        // JIKA KENDARAAN MASIH PARKIR
        if ($transaction->status !== 'masuk') {
            return redirect()
                ->route('transactions.index')
                ->with('error', 'Status transaksi tidak valid.');
        }

        $tariff = Tariff::where(
            'vehicle_type',
            $transaction->vehicle_type
        )
        ->where('is_active', true)
        ->first();

        if (!$tariff) {
            return redirect()
                ->route('transactions.index')
                ->with('error', 'Tarif kendaraan belum tersedia.');
        }

        $estimatedFee = $this->calculateParkingFee(
            $transaction,
            $tariff,
            now()
        );

        return view('transactions.checkout', compact(
            'transaction',
            'estimatedFee'
        ));
    }

    // PROSES PEMBAYARAN
    public function processCheckout(
        Request $request,
        ParkingTransaction $transaction
    ) {
        $validated = $request->validate([
            'amount_received' => 'required|numeric|min:0',
            'method' => 'required|in:tunai,non_tunai',
        ]);

        // PENANDA KENDARAAN KELUAR
        $kendaraanKeluar = false;

        DB::transaction(function () use (
            $transaction,
            $validated,
            &$kendaraanKeluar
        ) {

            $transaction = ParkingTransaction::whereKey($transaction->id)
                ->lockForUpdate()
                ->firstOrFail();

            // CEGAH PEMBAYARAN GANDA
            if ($transaction->payment()->exists()) {
                throw ValidationException::withMessages([
                    'transaction' => 'Pembayaran kendaraan ini sudah tercatat.',
                ]);
            }

            // JIKA KENDARAAN MASIH MASUK
            if ($transaction->status === 'masuk') {

                $tariff = Tariff::where(
                    'vehicle_type',
                    $transaction->vehicle_type
                )
                ->where('is_active', true)
                ->first();

                if (!$tariff) {
                    throw ValidationException::withMessages([
                        'transaction' => 'Tarif kendaraan belum tersedia.',
                    ]);
                }

                $exitTime = now();

                $fee = $this->calculateParkingFee(
                    $transaction,
                    $tariff,
                    $exitTime
                );

            } elseif ($transaction->status === 'keluar') {

                // GUNAKAN BIAYA YANG SUDAH TERSIMPAN
                $fee = (float) $transaction->parking_fee;

                $exitTime = $transaction->exit_time ?? now();

            } else {

                throw ValidationException::withMessages([
                    'transaction' => 'Status transaksi tidak valid.',
                ]);
            }

            // PERIKSA UANG YANG DITERIMA
            $received = (float) $validated['amount_received'];

            if ($received < $fee) {
                throw ValidationException::withMessages([
                    'amount_received' => 'Uang yang diterima kurang dari total biaya parkir.',
                ]);
            }

            $change = round($received - $fee, 2);

            // SIMPAN DATA PEMBAYARAN
            ParkingPayment::create([
                'parking_transaction_id' => $transaction->id,
                'user_id' => auth()->id(),
                'amount' => $fee,
                'amount_received' => $received,
                'change_amount' => $change,
                'method' => $validated['method'],
                'paid_at' => now(),
            ]);

            // JIKA MASIH MASUK, SEKALIGUS PROSES KENDARAAN KELUAR
            if ($transaction->status === 'masuk') {
                $transaction->update([
                    'exit_time' => $exitTime,
                    'parking_fee' => $fee,
                    'status' => 'keluar',
                ]);

                $kendaraanKeluar = true;
            }
        });

        // AMBIL DATA TRANSAKSI TERBARU
        $transaksiTerbaru = $transaction->fresh();

        // NOTIFIKASI KENDARAAN KELUAR
        if ($kendaraanKeluar) {
            $this->kirimNotifikasiTransaksi(
                'Kendaraan Keluar',
                'Kendaraan dengan plat nomor ' .
                $transaksiTerbaru->plate_number .
                ' telah keluar dari area parkir.'
            );
        }

        // NOTIFIKASI PEMBAYARAN BERHASIL
        $this->kirimNotifikasiTransaksi(
            'Pembayaran Berhasil',
            'Pembayaran parkir kendaraan ' .
            $transaksiTerbaru->plate_number .
            ' berhasil. Total biaya Rp' .
            number_format($transaksiTerbaru->parking_fee, 0, ',', '.') .
            '.'
        );

        // SETELAH BERHASIL, BUKA STRUK
        return redirect()
            ->route('transactions.receipt', $transaction->id)
            ->with('success', 'Pembayaran berhasil. Struk pembayaran tersedia.');
    }

    // MENGHITUNG BIAYA PARKIR
    private function calculateParkingFee(
        ParkingTransaction $transaction,
        Tariff $tariff,
        $exitTime
    ): float {
        $minutes = max(
            0,
            (int) $transaction->entry_time->diffInMinutes($exitTime)
        );

        // MINIMAL DIHITUNG 1 JAM
        $hours = max(1, (int) ceil($minutes / 60));

        $fee = $hours * (float) $tariff->hourly_rate;

        // BATAS MAKSIMAL BIAYA HARIAN
        if ($tariff->daily_max_rate !== null) {
            $days = (int) ceil($hours / 24);

            $maximumFee = $days * (float) $tariff->daily_max_rate;

            $fee = min($fee, $maximumFee);
        }

        return round($fee, 2);
    }

    // CETAK STRUK PEMBAYARAN
    public function receipt(ParkingTransaction $transaction)
    {
        $transaction->load([
            'parkingArea',
            'user',
            'payment'
        ]);

        if (
            $transaction->status !== 'keluar' ||
            !$transaction->payment
        ) {
            return redirect()
                ->route('transactions.index')
                ->with('error', 'Struk belum tersedia.');
        }

        return view('transactions.receipt', compact('transaction'));
    }

    // HAPUS TRANSAKSI
    public function destroy(ParkingTransaction $transaction)
    {
        // JANGAN HAPUS KENDARAAN YANG MASIH PARKIR
        if ($transaction->status === 'masuk') {
            return back()->with(
                'error',
                'Kendaraan masih parkir, transaksi tidak boleh dihapus.'
            );
        }

        // HAPUS PEMBAYARAN DAN TRANSAKSI SECARA AMAN
        DB::transaction(function () use ($transaction) {

            // Ambil ulang transaksi dengan penguncian
            $lockedTransaction = ParkingTransaction::whereKey(
                $transaction->id
            )
            ->lockForUpdate()
            ->firstOrFail();

            // HAPUS PEMBAYARAN TERLEBIH DAHULU
            $lockedTransaction->payment()->delete();

            // KEMUDIAN HAPUS TRANSAKSI PARKIR
            $lockedTransaction->delete();
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi dan data pembayarannya berhasil dihapus!');
    }

    // KIRIM NOTIFIKASI KEPADA ADMIN, PETUGAS, DAN OWNER
    private function kirimNotifikasiTransaksi($judul, $pesan)
    {
        $users = User::whereIn('role', [
            'admin',
            'petugas',
            'owner'
        ])->get();

        foreach ($users as $user) {
            $user->notify(
                new TransaksiParkirNotification(
                    $judul,
                    $pesan,
                    route('transactions.index')
                )
            );
        }
    }
}
