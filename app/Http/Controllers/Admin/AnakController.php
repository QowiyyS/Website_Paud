<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use Illuminate\Http\Request;

class AnakController extends Controller
{
    public function index(Request $request)
    {
        $query = Anak::with('wali')->orderBy('kelompok')->orderBy('nama_anak');

        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }

        $anakList = $query->get();
        return view('admin.anak.index', compact('anakList'));
    }

    public function create()
    {
        return view('admin.anak.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:anak,nis',
            'nama_anak' => 'required|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'kelompok' => 'required|in:KB,TK',
        ]);

        Anak::create($validated);

        return redirect()->route('admin.anak.index')->with('success', 'Data anak berhasil ditambahkan.');
    }

    public function edit(Anak $anak)
    {
        return view('admin.anak.edit', compact('anak'));
    }

    public function update(Request $request, Anak $anak)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:anak,nis,' . $anak->id_anak . ',id_anak',
            'nama_anak' => 'required|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'kelompok' => 'required|in:KB,TK',
        ]);

        $anak->update($validated);

        return redirect()->route('admin.anak.index')->with('success', 'Data anak berhasil diperbarui.');
    }

    public function destroy(Anak $anak)
    {
        try {
            $anak->delete();
            return redirect()->route('admin.anak.index')->with('success', 'Data anak berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.anak.index')->with('error', 'Data anak tidak dapat dihapus karena masih terhubung dengan wali murid atau rapor.');
        }
    }
}