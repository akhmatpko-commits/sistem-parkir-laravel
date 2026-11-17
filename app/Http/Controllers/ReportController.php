<?php

namespace App\Http\Controllers;

use App\Models\ParkingTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // VALIDASI TANGGAL
        $validated = $request->validate([
            'periode' => [
                'nullable',
                'in:hari_ini,kemarin,7_hari,bulan_ini,bulan_lalu,semua'
            ],
            'tanggal_mulai' => [
                'nullable',
                'date_format:Y-m-d'
            ],
            'tanggal_selesai' => [
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:tanggal_mulai'
            ],
        ]);

        $periode = $validated['periode'] ?? null;

        $tanggalMulai = null;
        $tanggalSelesai = null;
        $periodeLabel = '';

        // PILIHAN PERIODE CEPAT
        if ($periode) {

            switch ($periode) {

                case 'hari_ini':
                    $tanggalMulai = Carbon::today()->toDateString();
                    $tanggalSelesai = Carbon::today()->toDateString();
                    $periodeLabel = 'Hari Ini';
                    break;

                case 'kemarin':
                    $tanggalMulai = Carbon::yesterday()->toDateString();
                    $tanggalSelesai = Carbon::yesterday()->toDateString();
                    $periodeLabel = 'Kemarin';
                    break;

                case '7_hari':
                    $tanggalMulai = Carbon::today()
                        ->subDays(6)->toDateString();

                    $tanggalSelesai = Carbon::today()->toDateString();
                    $periodeLabel = '7 Hari Terakhir';
                    break;

                case 'bulan_ini':
                    $tanggalMulai = Carbon::now()
                        ->startOfMonth()->toDateString();

                    $tanggalSelesai = Carbon::now()
                        ->endOfMonth()->toDateString();

                    $periodeLabel = 'Bulan Ini';
                    break;

                case 'bulan_lalu':
                    $tanggalMulai = Carbon::now()
                        ->subMonthNoOverflow()
                        ->startOfMonth()->toDateString();

                    $tanggalSelesai = Carbon::now()
                        ->subMonthNoOverflow()
                        ->endOfMonth()->toDateString();

                    $periodeLabel = 'Bulan Lalu';
                    break;

                case 'semua':
                    $periodeLabel = 'Semua Data';
                    break;
            }

        } else {

            // FILTER TANGGAL MANUAL
            $tanggalMulai = $validated['tanggal_mulai'] ?? null;
            $tanggalSelesai = $validated['tanggal_selesai'] ?? null;

            // DEFAULT: BULAN INI
            if (!$tanggalMulai && !$tanggalSelesai) {

                $tanggalMulai = Carbon::now()
                    ->startOfMonth()->toDateString();

                $tanggalSelesai = Carbon::now()
                    ->endOfMonth()->toDateString();

                $periodeLabel = 'Bulan Ini';

            } else {

                $periodeLabel = 'Periode Pilihan';

            }
        }

        // QUERY TRANSAKSI
        $query = ParkingTransaction::where('status', 'keluar');

        if ($tanggalMulai) {
            $query->whereDate('exit_time', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $query->whereDate('exit_time', '<=', $tanggalSelesai);
        }

        // TOTAL PENDAPATAN
        $pendapatan = (clone $query)->sum('parking_fee');

        // DATA TRANSAKSI
        $transaksi = (clone $query)
            ->latest('exit_time')
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', compact(
            'transaksi',
            'pendapatan',
            'tanggalMulai',
            'tanggalSelesai',
            'periode',
            'periodeLabel'
        ));
    }
}
