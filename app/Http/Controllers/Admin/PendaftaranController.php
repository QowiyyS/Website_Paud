<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    /**
     * Tampilkan daftar pendaftaran masuk.
     */
    public function index(Request $request)
    {
        $query = Pendaftaran::query()->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nomor_registrasi', 'like', "%{$search}%")
                    ->orWhere('nama_wali', 'like', "%{$search}%")
                    ->orWhere('nomor_hp', 'like', "%{$search}%");
            });
        }

        $pendaftaranList = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Pendaftaran::count(),
            'menunggu' => Pendaftaran::where('status', 'menunggu')->count(),
            'diterima' => Pendaftaran::where('status', 'diterima')->count(),
            'ditolak' => Pendaftaran::where('status', 'ditolak')->count(),
            'kb' => Pendaftaran::where('program', 'KB')->count(),
            'tk' => Pendaftaran::where('program', 'TK')->count(),
        ];

        return view('admin.pendaftaran.index', compact('pendaftaranList', 'stats'));
    }

    /**
     * Tampilkan detail data formulir pendaftaran.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        // Format teks WhatsApp untuk admin menghubungi orang tua
        $namaAnak = $pendaftaran->nama_lengkap;
        $namaWali = $pendaftaran->nama_wali;
        $programLabel = $pendaftaran->program === 'KB' ? 'Kelompok Bermain (KB)' : 'Taman Kanak-Kanak (TK)';

        $pesanWa = "Halo Bapak/Ibu {$namaWali},\n\n"
            . "Kami dari pihak Panitia PPDB PAUD Haqqul Yaqin mengonfirmasi pendaftaran ananda *{$namaAnak}* (Program {$programLabel}) dengan No. Registrasi *{$pendaftaran->nomor_registrasi}*.\n\n"
            . "Status pendaftaran ananda saat ini: *" . strtoupper($pendaftaran->status) . "*.\n\n"
            . "Terima kasih.";

        $waUrl = 'https://wa.me/' . $pendaftaran->nomor_hp . '?text=' . rawurlencode($pesanWa);

        return view('admin.pendaftaran.show', compact('pendaftaran', 'waUrl'));
    }

    /**
     * Perbarui status pendaftaran (Menunggu / Diterima / Ditolak) & catatan admin.
     */
    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diterima,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pendaftaran->update($validated);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * Konversi data pendaftaran yang diterima menjadi siswa aktif (tabel anak).
     */
    public function jadikanSiswa(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->id_anak) {
            return back()->with('error', 'Calon siswa ini sudah pernah didaftarkan ke data siswa aktif.');
        }

        $validated = $request->validate([
            'nis' => 'required|string|unique:anak,nis',
        ], [
            'nis.required' => 'NIS wajib diisi untuk siswa baru.',
            'nis.unique' => 'NIS tersebut sudah digunakan oleh siswa lain.',
        ]);

        DB::beginTransaction();
        try {
            // Buat record siswa baru di tabel anak
            $anak = Anak::create([
                'nis' => $validated['nis'],
                'nama_anak' => $pendaftaran->nama_lengkap,
                'tempat_lahir' => $pendaftaran->tempat_lahir,
                'tanggal_lahir' => $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('Y-m-d') : null,
                'jenis_kelamin' => $pendaftaran->jenis_kelamin,
                'alamat' => $pendaftaran->alamat,
                'kelompok' => $pendaftaran->program,
            ]);

            // Kaitkan pendaftaran ke anak dan set status diterima
            $pendaftaran->update([
                'status' => 'diterima',
                'id_anak' => $anak->id_anak,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.anak.index')
                ->with('success', "Calon siswa {$pendaftaran->nama_lengkap} berhasil dimasukkan ke Data Siswa Aktif dengan NIS {$anak->nis}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data pendaftaran.
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
