<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeRapor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodeRaporController extends Controller
{
    public function index()
    {
        $periodeList = PeriodeRapor::orderByDesc('tahun_ajaran')
            ->orderByDesc('nama_periode')
            ->get();

        return view('admin.periode.index', compact('periodeList'));
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => [
                'required',
                'string',
                Rule::unique('periode_rapor')->where(function ($query) use ($request) {
                    return $query->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
            'tahun_ajaran' => 'required|string',
        ], [
            'nama_periode.unique' => 'Kombinasi semester dan tahun ajaran tersebut sudah ada.',
        ]);

        PeriodeRapor::create($validated);

        return redirect()->route('admin.periode.index')->with('success', 'Periode rapor berhasil ditambahkan.');
    }

    public function edit(PeriodeRapor $periode)
    {
        return view('admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, PeriodeRapor $periode)
    {
        $validated = $request->validate([
            'nama_periode' => [
                'required',
                'string',
                Rule::unique('periode_rapor')
                    ->ignore($periode->id_periode, 'id_periode')
                    ->where(function ($query) use ($request) {
                        return $query->where('tahun_ajaran', $request->tahun_ajaran);
                    }),
            ],
            'tahun_ajaran' => 'required|string',
        ], [
            'nama_periode.unique' => 'Kombinasi semester dan tahun ajaran tersebut sudah ada.',
        ]);

        $periode->update($validated);

        return redirect()->route('admin.periode.index')->with('success', 'Periode rapor berhasil diperbarui.');
    }

    public function destroy(PeriodeRapor $periode)
    {
        try {
            $periode->delete();
            return redirect()->route('admin.periode.index')->with('success', 'Periode rapor berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.periode.index')->with('error', 'Periode tidak dapat dihapus karena sudah digunakan pada data rapor.');
        }
    }
}