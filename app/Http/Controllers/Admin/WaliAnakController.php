<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaliAnakController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'id_anak' => 'required|exists:anak,id_anak',
            'hubungan' => 'required|in:ayah,ibu,wali',
            'utama' => 'required|in:0,1',
        ]);

        $pengguna = Pengguna::findOrFail($validated['id_pengguna']);

        if ($pengguna->peran !== 'walimurid') {
            return back()->with('error', 'Hanya akun dengan peran Wali Murid yang dapat ditautkan dengan anak.');
        }

        $sudahAda = DB::table('wali_anak')
            ->where('id_pengguna', $validated['id_pengguna'])
            ->where('id_anak', $validated['id_anak'])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Anak tersebut sudah terhubung dengan akun wali ini.');
        }

        DB::table('wali_anak')->insert([
            'id_pengguna' => $validated['id_pengguna'],
            'id_anak' => $validated['id_anak'],
            'hubungan' => $validated['hubungan'],
            'utama' => (int) $validated['utama'],
        ]);

        return back()->with('success', 'Anak berhasil ditautkan ke akun wali murid.');
    }

    public function destroy($id_pengguna, $id_anak)
    {
        DB::table('wali_anak')
            ->where('id_pengguna', $id_pengguna)
            ->where('id_anak', $id_anak)
            ->delete();

        return back()->with('success', 'Tautan anak dari wali murid berhasil dilepas.');
    }
}