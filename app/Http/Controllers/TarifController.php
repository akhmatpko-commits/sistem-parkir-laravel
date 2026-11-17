<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::with('kendaraan')
            ->latest()
            ->paginate(10);

        return view('tarif.index', compact('tarifs'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::where('status', true)
            ->orderBy('nama_kendaraan')
            ->get();

        return view('tarif.create', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => [
                'required',
                'exists:kendaraans,id',
                Rule::unique('tarifs', 'kendaraan_id'),
            ],
            'tarif_per_jam' => ['required', 'numeric', 'min:0'],
            'tarif_maksimal' => ['nullable', 'numeric', 'min:0'],
            'tarif_menginap' => ['required', 'numeric', 'min:0'],
        ]);

        Tarif::create($validated);

        return redirect()
            ->route('tarif.index')
            ->with('success', 'Tarif parkir berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif)
    {
        $kendaraans = Kendaraan::orderBy('nama_kendaraan')->get();

        return view('tarif.edit', compact('tarif', 'kendaraans'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $validated = $request->validate([
            'kendaraan_id' => [
                'required',
                'exists:kendaraans,id',
                Rule::unique('tarifs', 'kendaraan_id')
                    ->ignore($tarif->id),
            ],
            'tarif_per_jam' => ['required', 'numeric', 'min:0'],
            'tarif_maksimal' => ['nullable', 'numeric', 'min:0'],
            'tarif_menginap' => ['required', 'numeric', 'min:0'],
        ]);

        $tarif->update($validated);

        return redirect()
            ->route('tarif.index')
            ->with('success', 'Tarif parkir berhasil diperbarui.');
    }

    public function destroy(Tarif $tarif)
    {
        if ($tarif->parkirs()->exists()) {
            return back()->with(
                'error',
                'Tarif tidak dapat dihapus karena sudah digunakan dalam transaksi parkir.'
            );
        }

        $tarif->delete();

        return redirect()
            ->route('tarif.index')
            ->with('success', 'Tarif parkir berhasil dihapus.');
    }
}
