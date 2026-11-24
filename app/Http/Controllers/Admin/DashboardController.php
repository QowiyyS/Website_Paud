<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pengguna;
use App\Models\HeadRaport;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKB = Anak::where('kelompok', 'KB')->count();
        $totalTK = Anak::where('kelompok', 'TK')->count();
        $totalGuru = Pengguna::whereIn('peran', ['guru', 'admin_guru'])->count();
        $totalWali = Pengguna::where('peran', 'walimurid')->count();
        $raporMenunggu = HeadRaport::whereIn('status_rapor', ['diajukan', 'disetujui'])->count();

        return view('admin.dashboard', compact(
            'totalKB',
            'totalTK',
            'totalGuru',
            'totalWali',
            'raporMenunggu'
        ));
    }
}