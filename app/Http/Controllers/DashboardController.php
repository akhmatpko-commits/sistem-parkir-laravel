<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\ParkingTransaction;
use App\Models\ParkingArea;

class DashboardController extends Controller
{
    // DASHBOARD OWNER
    public function owner()
    {
        // TOTAL DATA KENDARAAN
        $totalKendaraan = Kendaraan::count();

        // TOTAL KENDARAAN SEDANG PARKIR
        $kendaraanMasuk = ParkingTransaction::where(
            'status', 'masuk'
        )->count();

        // TOTAL KENDARAAN SUDAH KELUAR
        $kendaraanKeluar = ParkingTransaction::where(
            'status', 'keluar'
        )->count();

        // TOTAL PENDAPATAN
        $totalPendapatan = ParkingTransaction::where(
            'status', 'keluar'
        )->sum('parking_fee');

        // TOTAL AREA PARKIR
        $totalArea = ParkingArea::count();

        // TRANSAKSI TERBARU
        $transaksiTerbaru = ParkingTransaction::with([
            'parkingArea',
            'user',
            'payment'
        ])
        ->latest()
        ->take(10)
        ->get();

        return view('dashboard.owner', compact(
            'totalKendaraan',
            'kendaraanMasuk',
            'kendaraanKeluar',
            'totalPendapatan',
            'totalArea',
            'transaksiTerbaru'
        ));
    }

    // DASHBOARD ADMIN
    public function admin()
    {
        $totalKendaraan = Kendaraan::count();

        $kendaraanMasuk = ParkingTransaction::where(
            'status', 'masuk'
        )->count();

        $kendaraanKeluar = ParkingTransaction::where(
            'status', 'keluar'
        )->count();

        $totalPendapatan = ParkingTransaction::where(
            'status', 'keluar'
        )->sum('parking_fee');

        $totalArea = ParkingArea::count();

        $transaksiTerbaru = ParkingTransaction::with([
            'parkingArea',
            'user',
            'payment'
        ])
        ->latest()
        ->take(10)
        ->get();

        return view('dashboard.admin', compact(
            'totalKendaraan',
            'kendaraanMasuk',
            'kendaraanKeluar',
            'totalPendapatan',
            'totalArea',
            'transaksiTerbaru'
        ));
    }

    // DASHBOARD PETUGAS
    public function petugas()
    {
        $kendaraanMasuk = ParkingTransaction::where(
            'status', 'masuk'
        )->count();

        $transaksiHariIni = ParkingTransaction::whereDate(
            'created_at', today()
        )->count();

        $transaksiTerbaru = ParkingTransaction::with([
            'parkingArea',
            'user'
        ])
        ->latest()
        ->take(5)
        ->get();

        return view('dashboard.petugas', compact(
            'kendaraanMasuk',
            'transaksiHariIni',
            'transaksiTerbaru'
        ));
    }
}
