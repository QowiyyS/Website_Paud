<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran online.
     */
    public function create()
    {
        return view('pendaftaran.create');
    }

    /**
     * Simpan data formulir pendaftaran online yang disesuaikan dengan formulir PDF resmi.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // Pilihan Program
            'program' => 'required|in:KB,TK',

            // 1. Identitas Siswa
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'usia' => 'nullable|string|max:50',
            'berat_badan' => 'nullable|string|max:20',
            'tinggi_badan' => 'nullable|string|max:20',
            'lingkar_kepala' => 'nullable|string|max:20',
            'anak_ke' => 'nullable|integer|min:1|max:25',
            'jumlah_saudara' => 'nullable|integer|min:0|max:25',
            'cita_cita' => 'nullable|string|max:150',
            'hobby' => 'nullable|string|max:150',
            'riwayat_penyakit' => 'nullable|string|max:500',
            'makanan_dihindari' => 'nullable|string|max:500',
            'minuman_dihindari' => 'nullable|string|max:500',
            'alamat' => 'required|string|max:1000',

            // 2. Data Ayah
            'nama_ayah' => 'nullable|string|max:255',
            'ttl_ayah' => 'nullable|string|max:150',
            'pekerjaan_ayah' => 'nullable|string|max:150',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pendapatan_ayah' => 'nullable|string|max:100',
            'usia_ayah' => 'nullable|string|max:30',
            'alamat_ayah' => 'nullable|string|max:1000',
            'no_hp_ayah' => 'nullable|string|max:30',

            // 3. Data Ibu
            'nama_ibu' => 'nullable|string|max:255',
            'ttl_ibu' => 'nullable|string|max:150',
            'pekerjaan_ibu' => 'nullable|string|max:150',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pendapatan_ibu' => 'nullable|string|max:100',
            'usia_ibu' => 'nullable|string|max:30',
            'alamat_ibu' => 'nullable|string|max:1000',
            'no_hp_ibu' => 'nullable|string|max:30',
        ], [
            'program.required' => 'Silakan pilih program pendidikan (KB atau TK).',
            'nama_lengkap.required' => 'Nama lengkap anak wajib diisi sesuai dokumen.',
            'tempat_lahir.required' => 'Tempat lahir anak wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir anak wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir anak tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin anak wajib dipilih.',
            'alamat.required' => 'Alamat tempat tinggal anak wajib diisi.',
        ])->validate();

        // Validasi minimal ada salah satu kontak orang tua yang diisi
        if (empty($validated['no_hp_ayah']) && empty($validated['no_hp_ibu'])) {
            return back()->withInput()->withErrors([
                'kontak' => 'Mohon isi setidaknya salah satu nomor Telpon/HP/WhatsApp Orang Tua (Ayah atau Ibu).'
            ]);
        }

        // Standarisasi format nomor HP jika diisi
        if (!empty($validated['no_hp_ayah'])) {
            $cleanAyah = preg_replace('/[^0-9]/', '', $validated['no_hp_ayah']);
            if (str_starts_with($cleanAyah, '0')) {
                $cleanAyah = '62' . substr($cleanAyah, 1);
            }
            $validated['no_hp_ayah'] = $cleanAyah;
        }

        if (!empty($validated['no_hp_ibu'])) {
            $cleanIbu = preg_replace('/[^0-9]/', '', $validated['no_hp_ibu']);
            if (str_starts_with($cleanIbu, '0')) {
                $cleanIbu = '62' . substr($cleanIbu, 1);
            }
            $validated['no_hp_ibu'] = $cleanIbu;
        }

        // Hitung usia otomatis jika belum terisi
        if (empty($validated['usia']) && !empty($validated['tanggal_lahir'])) {
            $birth = \Carbon\Carbon::parse($validated['tanggal_lahir']);
            $diff = $birth->diff(now());
            $validated['usia'] = "{$diff->y} Tahun {$diff->m} Bulan";
        }

        // Generate nomor registrasi otomatis
        $validated['nomor_registrasi'] = Pendaftaran::generateNomorRegistrasi($validated['program']);
        $validated['jalur'] = 'online';
        $validated['status'] = 'menunggu';

        $pendaftaran = Pendaftaran::create($validated);

        return redirect()
            ->route('pendaftaran.sukses', $pendaftaran->nomor_registrasi)
            ->with('success', 'Formulir pendaftaran berhasil dikirim!');
    }

    /**
     * Tampilkan halaman sukses registrasi dengan ringkasan & tombol konfirmasi WhatsApp.
     */
    public function sukses(string $nomor)
    {
        $pendaftaran = Pendaftaran::where('nomor_registrasi', $nomor)->firstOrFail();

        // Siapkan link WhatsApp konfirmasi ke panitia sekolah
        $nomorPanitia = '6281225852505';
        $programLabel = $pendaftaran->program === 'KB' ? 'Kelompok Bermain (KB)' : 'Taman Kanak-Kanak (TK)';
        $genderLabel = $pendaftaran->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
        $namaWali = $pendaftaran->nama_ayah ?: ($pendaftaran->nama_ibu ?: 'Orang Tua / Wali');
        $kontakWali = $pendaftaran->no_hp_ayah ?: ($pendaftaran->no_hp_ibu ?: '-');

        $pesanWa = "Halo Panitia PPDB PAUD Haqqul Yaqin,\n\n"
            . "Saya ingin mengonfirmasi pendaftaran online siswa baru:\n"
            . "• No. Registrasi: {$pendaftaran->nomor_registrasi}\n"
            . "• Nama Anak: {$pendaftaran->nama_lengkap} ({$genderLabel})\n"
            . "• Program: {$programLabel}\n"
            . "• Nama Orang Tua: {$namaWali}\n"
            . "• Kontak: +{$kontakWali}\n\n"
            . "Mohon informasi verifikasi berkas selanjutnya. Terima kasih!";

        $waUrl = 'https://wa.me/' . $nomorPanitia . '?text=' . rawurlencode($pesanWa);

        return view('pendaftaran.sukses', compact('pendaftaran', 'waUrl'));
    }
}
