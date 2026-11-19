<?php

namespace App\Http\Controllers;

use App\Models\ParkingArea;
use Illuminate\Support\Facades\DB;

class PetugasSlotParkirController extends Controller
{
    public function index()
    {
        // Mengambil semua area parkir yang aktif
        $areas = ParkingArea::where('status', 'aktif')
            ->orderBy('area_name')
            ->get();

        // Menghitung kendaraan yang masih berada di setiap area
        foreach ($areas as $area) {

            $terisi = DB::table('parking_transactions')
                ->where('parking_area_id', $area->id)
                ->where('status', 'masuk')
                ->count();

            $area->terisi = $terisi;

            // Menghitung slot yang masih tersedia
            $area->tersedia = max(0, $area->capacity - $terisi);
        }

        return view('petugas.slot-parkir.index', compact('areas'));
    }
}
