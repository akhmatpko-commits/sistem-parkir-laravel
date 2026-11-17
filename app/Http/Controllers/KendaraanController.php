<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::withCount(['tarifs', 'parkirs'])
            ->latest()
            ->paginate(10);

        return view('kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'kode_kendaraan' => [
                'required', 'string', 'max:255', 'unique:kendaraans,kode_kendaraan'
            ],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        Kendaraan::create($validated);

        return redirect()
            ->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'kode_kendaraan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kendaraans', 'kode_kendaraan')
                    ->ignore($kendaraan->id),
            ],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        $kendaraan->update($validated);

        return redirect()
            ->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        if (
            $kendaraan->tarifs()->exists() ||
            $kendaraan->parkirs()->exists()
        ) {
            return back()->with(
                'error',
                'Kendaraan tidak dapat dihapus karena sudah digunakan dalam tarif atau transaksi parkir.'
            );
        }

        $kendaraan->delete();

        return redirect()
            ->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil dihapus.');
    }
}
