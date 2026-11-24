<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Anak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::with('anak')->orderBy('peran')->orderBy('kode_login');

        if ($request->filled('peran')) {
            $query->where('peran', $request->peran);
        }

        $penggunaList = $query->get();
        return view('admin.pengguna.index', compact('penggunaList'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_login' => 'required|string|unique:pengguna,kode_login',
            'nama_lengkap' => 'required|string',
            'password' => 'required|string|min:6',
            'peran' => 'required|in:admin,guru,walimurid,admin_guru',
        ]);

        Pengguna::create([
            'kode_login' => $validated['kode_login'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'password_hash' => Hash::make($validated['password']),
            'peran' => $validated['peran'],
        ]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function show(Pengguna $pengguna)
    {
        $pengguna->load('anak');
        // Ambil daftar anak yang belum terhubung dengan wali ini untuk dropdown penautan
        $terhubungIds = $pengguna->anak->pluck('id_anak')->toArray();
        $anakTersedia = Anak::whereNotIn('id_anak', $terhubungIds)
                            ->orderBy('kelompok')
                            ->orderBy('nama_anak')
                            ->get();

        return view('admin.pengguna.show', compact('pengguna', 'anakTersedia'));
    }

    public function edit(Pengguna $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $validated = $request->validate([
            'kode_login' => 'required|string|unique:pengguna,kode_login,' . $pengguna->id_pengguna . ',id_pengguna',
            'nama_lengkap' => 'required|string',
            'password' => 'nullable|string|min:6',
            'peran' => 'required|in:admin,guru,walimurid,admin_guru',
        ]);

        $dataUpdate = [
            'kode_login' => $validated['kode_login'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'peran' => $validated['peran'],
        ];

        if ($request->filled('password')) {
            $dataUpdate['password_hash'] = Hash::make($validated['password']);
        }

        $pengguna->update($dataUpdate);

        return redirect()->route('admin.pengguna.index')->with('success', 'Data akun pengguna berhasil diperbarui.');
    }

    public function destroy(Pengguna $pengguna)
    {
        try {
            $pengguna->delete();
            return redirect()->route('admin.pengguna.index')->with('success', 'Akun pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.index')->with('error', 'Akun tidak dapat dihapus karena masih memiliki relasi anak atau riwayat rapor.');
        }
    }
}