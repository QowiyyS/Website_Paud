<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Pengguna;
use App\Models\HeadRaport;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard Utama Admin / Kepala Sekolah.
     */
    public function index()
    {
        $totalSiswa = Anak::count();
        $totalKB = Anak::where('kelompok', 'KB')->count();
        $totalTK = Anak::where('kelompok', 'TK')->count();
        $totalGuru = Pengguna::whereIn('peran', ['guru', 'admin_guru'])->count();
        $totalWali = Pengguna::where('peran', 'walimurid')->count();
        $totalRapor = HeadRaport::count();
        $totalPendaftaranMenunggu = Pendaftaran::where('status', 'menunggu')->count();

        // Rapor yang diajukan oleh guru dan menunggu persetujuan Kepala Sekolah
        $raporMenunggu = HeadRaport::with(['anak', 'periode', 'pembuat'])
            ->where('status_rapor', 'diajukan')
            ->get();

        $daftarGuru = Pengguna::whereIn('peran', ['guru', 'admin_guru', 'admin'])->get();
        $daftarSiswaTerbaru = Anak::latest('id_anak')->take(5)->get();
        $pendaftaranTerbaru = Pendaftaran::latest('id_pendaftaran')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalKB',
            'totalTK',
            'totalGuru',
            'totalWali',
            'totalRapor',
            'totalPendaftaranMenunggu',
            'pendaftaranTerbaru',
            'raporMenunggu',
            'daftarGuru',
            'daftarSiswaTerbaru'
        ));
    }
}
