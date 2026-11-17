<?php

namespace App\Http\Controllers;

use App\Models\ParkingArea;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParkingAreaController extends Controller
{
    public function index()
    {
        $areas = ParkingArea::withCount([
            'transactions as occupied' => function ($query) {
                $query->where('status', 'masuk');
            }
        ])->latest()->paginate(10);

        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    
public function store(Request $request)
{
    $validated = $request->validate([
        'area_code' => 'required|string|max:20|unique:parking_areas,area_code',
        'area_name' => 'required|string|max:100',
        'vehicle_type' => 'required|in:Motor,Mobil,Semua',
        'capacity' => 'required|integer|min:1',
        'status' => 'required|in:aktif,nonaktif',
    ], [
        'area_code.required' => 'Kode area wajib diisi.',
        'area_code.unique' => 'Kode area sudah digunakan.',
        'area_name.required' => 'Nama area wajib diisi.',
        'vehicle_type.required' => 'Jenis kendaraan wajib dipilih.',
        'capacity.required' => 'Kapasitas parkir wajib diisi.',
        'capacity.integer' => 'Kapasitas harus berupa angka.',
        'capacity.min' => 'Kapasitas minimal 1.',
        'status.required' => 'Status area wajib dipilih.',
    ]);

    ParkingArea::create($validated);

    return redirect()
        ->route('areas.index')
        ->with('success', 'Area parkir berhasil ditambahkan!');
}

    public function edit($id)
    {
        $area = ParkingArea::findOrFail($id);

        return view('areas.edit', compact('area'));
    }

    
public function update(Request $request, ParkingArea $area)
{
    $validated = $request->validate([
        'area_code' => 'required|string|max:20|unique:parking_areas,area_code,' . $area->id,
        'area_name' => 'required|string|max:100',
        'vehicle_type' => 'required|in:Motor,Mobil,Semua',
        'capacity' => 'required|integer|min:1',
        'status' => 'required|in:aktif,nonaktif',
    ], [
        'area_code.required' => 'Kode area wajib diisi.',
        'area_code.unique' => 'Kode area sudah digunakan.',
        'area_name.required' => 'Nama area wajib diisi.',
        'capacity.min' => 'Kapasitas minimal 1.',
    ]);

    $occupied = $area->transactions()
        ->where('status', 'masuk')
        ->count();

    if ($validated['capacity'] < $occupied) {
        return back()
            ->withInput()
            ->with('error', 'Kapasitas tidak boleh kurang dari jumlah kendaraan yang sedang parkir.');
    }

    if ($validated['status'] === 'nonaktif' && $occupied > 0) {
        return back()
            ->withInput()
            ->with('error', 'Area tidak dapat dinonaktifkan karena masih terdapat kendaraan.');
    }

    $area->update($validated);

    return redirect()
        ->route('areas.index')
        ->with('success', 'Area parkir berhasil diperbarui!');
}


    public function destroy($id)
    {
        $area = ParkingArea::findOrFail($id);

        if ($area->transactions()->exists()) {
            return back()->withErrors([
                'area' => 'Area memiliki riwayat transaksi sehingga tidak dapat dihapus.'
            ]);
        }

        $area->delete();

        return redirect()->route('areas.index')
            ->with('success', 'Area parkir berhasil dihapus!');
    }
}
