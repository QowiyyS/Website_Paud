<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\BodyRaport;
use App\Models\HeadRaport;
use App\Models\PeriodeRapor;
use App\Models\RiwayatPerubahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RaporController extends Controller
{
    /**
     * Tampilkan daftar rapor anak (untuk Admin dan Guru).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $periodeId = $request->query('periode');
        $status = $request->query('status');

        $periodes = PeriodeRapor::orderBy('id_periode', 'asc')->get();

        $query = HeadRaport::with(['anak', 'periode', 'pembuat', 'penyetuju'])
            ->latest('id_rapor');

        if ($periodeId) {
            $query->where('id_periode', $periodeId);
        }

        if ($status) {
            $query->where('status_rapor', $status);
        }

        $rapors = $query->paginate(15)->withQueryString();

        return view('rapor.index', compact('rapors', 'periodes', 'user', 'periodeId', 'status'));
    }

    /**
     * Form buat rapor baru.
     */
    public function create(Request $request)
    {
        $anaks = Anak::orderBy('nama_anak', 'asc')->get();
        $periodes = PeriodeRapor::orderBy('id_periode', 'asc')->get();
        $selectedAnak = $request->query('anak');

        return view('rapor.create', compact('anaks', 'periodes', 'selectedAnak'));
    }

    /**
     * Simpan rapor baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_anak'    => 'required|exists:anak,id_anak',
            'id_periode' => 'required|exists:periode_rapor,id_periode',
            'aksi'       => 'required|in:draf,ajukan,terbitkan',
            'narasi'     => 'required|array',
            'narasi.*'   => 'nullable|string',
        ]);

        $user = Auth::user();

        // Validasi hak publikasi: hanya Admin (Kepsek) yang boleh langsung menerbitkan
        if ($request->aksi === 'terbitkan' && !$user->isAdmin()) {
            abort(403, 'Guru tidak memiliki hak untuk menyetujui dan mempublikasikan rapor. Rapor harus diajukan ke Kepala Sekolah.');
        }

        // Cek apakah rapor untuk anak & periode ini sudah ada
        $cek = HeadRaport::where('id_anak', $request->id_anak)
            ->where('id_periode', $request->id_periode)
            ->first();

        if ($cek) {
            return back()->withInput()->with('error', 'Rapor untuk anak dan periode triwulan tersebut sudah pernah dibuat. Silakan edit rapor yang sudah ada.');
        }

        DB::beginTransaction();
        try {
            $status = match ($request->aksi) {
                'ajukan'    => 'diajukan',
                'terbitkan' => 'diterbitkan',
                default     => 'draf',
            };

            $rapor = new HeadRaport();
            $rapor->id_anak      = $request->id_anak;
            $rapor->id_periode   = $request->id_periode;
            $rapor->dibuat_oleh  = $user->id_pengguna;
            $rapor->status_rapor = $status;
            $rapor->dibuat_pada  = now()->format('Y-m-d H:i:s');

            if ($status === 'diajukan') {
                $rapor->diajukan_pada = now()->format('Y-m-d H:i:s');
            } elseif ($status === 'diterbitkan') {
                $rapor->diajukan_pada    = now()->format('Y-m-d H:i:s');
                $rapor->disetujui_oleh   = $user->id_pengguna;
                $rapor->disetujui_pada   = now()->format('Y-m-d H:i:s');
                $rapor->diterbitkan_oleh = $user->id_pengguna;
                $rapor->diterbitkan_pada = now()->format('Y-m-d H:i:s');
            }

            $rapor->save();

            // Simpan 4 aspek penilaian naratif
            $judulAspek = [
                1 => 'Nilai Agama dan Budi Pekerti',
                2 => 'Jati Diri (Fisik Motorik & Sosial-Emosional)',
                3 => 'Dasar Literasi, Sains & Seni',
                4 => 'Catatan dan Saran Perkembangan Guru',
            ];

            foreach ($judulAspek as $urutan => $judul) {
                $isi = $request->narasi[$urutan] ?? '-';
                BodyRaport::create([
                    'id_rapor'     => $rapor->id_rapor,
                    'jenis_bagian' => 'narasi',
                    'judul_bagian' => $judul,
                    'isi_narasi'   => $isi ?: '-',
                    'urutan'       => $urutan,
                ]);
            }

            DB::commit();

            $pesan = match ($status) {
                'diajukan'    => 'Rapor berhasil disimpan dan diajukan ke Kepala Sekolah untuk persetujuan.',
                'diterbitkan' => 'Rapor berhasil disetujui dan dipublikasikan ke Wali Murid oleh Kepala Sekolah.',
                default       => 'Rapor berhasil disimpan sebagai draf.',
            };

            return redirect()->route('rapor.index')->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan rapor: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit rapor anak (Bisa oleh Guru maupun Kepala Sekolah).
     */
    public function edit($id)
    {
        $rapor = HeadRaport::with(['anak', 'periode', 'bagian' => function ($q) {
            $q->orderBy('urutan', 'asc');
        }, 'pembuat', 'penyetuju'])->findOrFail($id);

        $user = Auth::user();

        return view('rapor.edit', compact('rapor', 'user'));
    }

    /**
     * Update isi rapor (Guru & Kepala Sekolah).
     */
    public function update(Request $request, $id)
    {
        $rapor = HeadRaport::with('bagian')->findOrFail($id);
        $user = Auth::user();

        $request->validate([
            'aksi'     => 'required|in:draf,ajukan,terbitkan,revisi',
            'narasi'   => 'required|array',
            'narasi.*' => 'nullable|string',
        ]);

        // Keamanan: Guru DILARANG menyetujui atau menerbitkan rapor
        if (in_array($request->aksi, ['terbitkan']) && !$user->isAdmin()) {
            abort(403, 'Akses Ditolak: Hanya Kepala Sekolah yang berwenang menyetujui dan menerbitkan (publish) rapor.');
        }

        DB::beginTransaction();
        try {
            // Update narasi pada setiap blok dan catat riwayat perubahan jika diedit
            foreach ($rapor->bagian as $bagian) {
                $urutan = $bagian->urutan;
                $narasiBaru = $request->narasi[$urutan] ?? $bagian->isi_narasi;

                if ($narasiBaru !== $bagian->isi_narasi) {
                    RiwayatPerubahan::create([
                        'id_rapor'        => $rapor->id_rapor,
                        'id_blok'         => $bagian->id_blok,
                        'id_pengguna'     => $user->id_pengguna,
                        'isi_sebelum'     => $bagian->isi_narasi,
                        'isi_sesudah'     => $narasiBaru,
                        'waktu_perubahan' => now()->format('Y-m-d H:i:s'),
                    ]);

                    $bagian->isi_narasi = $narasiBaru ?: '-';
                    $bagian->save();
                }
            }

            // Atur status berdasarkan aksi yang dipilih
            if ($request->aksi === 'terbitkan' && $user->isAdmin()) {
                // Kepala Sekolah menyetujui & menerbitkan rapor
                $rapor->status_rapor    = 'diterbitkan';
                $rapor->disetujui_oleh  = $user->id_pengguna;
                $rapor->disetujui_pada  = now()->format('Y-m-d H:i:s');
                $rapor->diterbitkan_oleh = $user->id_pengguna;
                $rapor->diterbitkan_pada = now()->format('Y-m-d H:i:s');
                $pesan = 'Rapor anak berhasil disetujui & dipublikasikan oleh Kepala Sekolah! Sekarang wali murid dapat melihat rapor ini.';
            } elseif ($request->aksi === 'revisi' && $user->isAdmin()) {
                // Kepala Sekolah meminta guru melakukan revisi
                $rapor->status_rapor = 'perlu_revisi';
                $pesan = 'Status rapor diubah menjadi "Perlu Revisi" dan dikembalikan kepada guru pengampu.';
            } elseif ($request->aksi === 'ajukan') {
                // Guru / Kepsek mengajukan rapor
                $rapor->status_rapor   = 'diajukan';
                $rapor->diajukan_pada = now()->format('Y-m-d H:i:s');
                $pesan = 'Rapor berhasil diajukan kepada Kepala Sekolah untuk proses pemeriksaan dan persetujuan.';
            } else {
                // Simpan perubahan tetap draf / status lama
                if ($rapor->status_rapor === 'perlu_revisi' && !$user->isAdmin()) {
                    // Jika guru mengedit draf revisi
                    $pesan = 'Perubahan draf berhasil disimpan. Silakan klik "Ajukan ke Kepala Sekolah" jika revisi telah selesai.';
                } else {
                    $pesan = 'Perubahan isi rapor berhasil disimpan.';
                }
            }

            $rapor->save();
            DB::commit();

            return redirect()->route('rapor.index')->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui rapor: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail atau cetak rapor anak.
     */
    public function show($id)
    {
        $rapor = HeadRaport::with([
            'anak.wali',
            'periode',
            'bagian' => function ($q) {
                $q->orderBy('urutan', 'asc');
            },
            'pembuat',
            'penyetuju',
            'riwayatPerubahan.pengguna'
        ])->findOrFail($id);

        $user = Auth::user();

        // Validasi untuk Wali Murid:
        // 1. Rapor HARUS berstatus 'diterbitkan'
        // 2. Anak tersebut HARUS anak dari wali murid yang sedang login
        if ($user->isWali()) {
            if ($rapor->status_rapor !== 'diterbitkan') {
                abort(403, 'Rapor ini masih dalam tahap pemeriksaan sekolah dan belum dipublikasikan oleh Kepala Sekolah.');
            }

            $isMyChild = $user->anak()->where('anak.id_anak', $rapor->id_anak)->exists();
            if (!$isMyChild) {
                abort(403, 'Akses Ditolak: Anda hanya berhak melihat rapor buah hati Anda sendiri.');
            }
        }

        return view('rapor.show', compact('rapor', 'user'));
    }
}
