<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\HeadRaport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Dashboard Utama Guru / Pendidik.
     */
    public function index()
    {
        $guru = Auth::user();
        $totalSiswa = Anak::count();
        $raporSaya = HeadRaport::where('dibuat_oleh', $guru->id_pengguna)->count();
        $daftarSiswa = Anak::orderBy('nama_anak', 'asc')->get();

        return view('guru.dashboard', compact('guru', 'totalSiswa', 'raporSaya', 'daftarSiswa'));
    }
}
