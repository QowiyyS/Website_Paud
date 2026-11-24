<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeadRaport;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaporAdminController extends Controller
{
    private function getAdminId(): int
    {
        return auth()->id() ?? Pengguna::where('peran', 'admin')->value('id_pengguna') ?? 1;
    }

    public function index(Request $request)
    {
        $query = HeadRaport::with(['anak', 'periode', 'pembuat'])
            ->orderByDesc('id_rapor');

        if ($request->filled('status')) {
            $query->where('status_rapor', $request->status);
        }

        $raporList = $query->get();
        return view('admin.rapor.index', compact('raporList'));
    }

    public function show($id_rapor)
    {
        $rapor = HeadRaport::with([
            'anak',
            'periode',
            'pembuat',
            'penyetuju',
            'penerbit',
            'blok' => function ($q) {
                $q->orderBy('urutan');
            },
            'blok.komentar.pengguna',
            'riwayat.pengguna',
        ])->findOrFail($id_rapor);

        return view('admin.rapor.show', compact('rapor'));
    }

    public function setujui($id_rapor)
    {
        $rapor = HeadRaport::findOrFail($id_rapor);

        if ($rapor->status_rapor !== 'diajukan') {
            return back()->with('error', 'Hanya rapor berstatus "diajukan" yang dapat disetujui.');
        }

        $rapor->update([
            'status_rapor' => 'disetujui',
            'disetujui_oleh' => $this->getAdminId(),
            'disetujui_pada' => now()->format('Y-m-d H:i:s'),
        ]);

        return back()->with('success', 'Rapor telah disetujui oleh Kepala Sekolah / Admin.');
    }

    public function terbitkan($id_rapor)
    {
        $rapor = HeadRaport::findOrFail($id_rapor);

        if ($rapor->status_rapor !== 'disetujui' || is_null($rapor->disetujui_oleh)) {
            return back()->with('error', 'Rapor wajib disetujui terlebih dahulu sebelum diterbitkan.');
        }

        $rapor->update([
            'status_rapor' => 'diterbitkan',
            'diterbitkan_oleh' => $this->getAdminId(),
            'diterbitkan_pada' => now()->format('Y-m-d H:i:s'),
        ]);

        return back()->with('success', 'Rapor berhasil diterbitkan dan kini dapat diakses oleh Wali Murid.');
    }

    public function bukaUlang(Request $request, $id_rapor)
    {
        $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $rapor = HeadRaport::findOrFail($id_rapor);

        if ($rapor->status_rapor !== 'diterbitkan') {
            return back()->with('error', 'Hanya rapor berstatus "diterbitkan" yang dapat dibuka ulang.');
        }

        DB::transaction(function () use ($rapor, $request) {
            $statusLama = $rapor->status_rapor;

            $rapor->update([
                'status_rapor' => 'perlu_revisi',
                'diterbitkan_oleh' => null,
                'diterbitkan_pada' => null,
            ]);

            DB::table('riwayat_perubahan')->insert([
                'id_rapor' => $rapor->id_rapor,
                'id_blok' => null,
                'id_pengguna' => $this->getAdminId(),
                'isi_sebelum' => 'Status: ' . $statusLama,
                'isi_sesudah' => 'Dibuka ulang ke perlu_revisi. Alasan: ' . $request->alasan,
                'waktu_perubahan' => now()->format('Y-m-d H:i:s'),
            ]);
        });

        return back()->with('success', 'Rapor terbit berhasil dibuka ulang untuk revisi dan tercatat di riwayat perubahan.');
    }
}