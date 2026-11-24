<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\BodyRaport;
use App\Models\HeadRaport;
use App\Models\Pengguna;
use App\Models\PeriodeRapor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin (Kepala Sekolah)
        $admin = Pengguna::firstOrCreate(
            ['kode_login' => 'admin'],
            [
                'nama_lengkap'  => 'Hj. Nurul Khotimah (Kepala Sekolah)',
                'password_hash' => Hash::make('admin123'),
                'peran'         => 'admin',
            ]
        );

        // 2. Buat Akun Guru
        $guru1 = Pengguna::firstOrCreate(
            ['kode_login' => 'guru'],
            [
                'nama_lengkap'  => 'Ibu Siti Rahma, S.Pd (Guru Kelas KB)',
                'password_hash' => Hash::make('guru123'),
                'peran'         => 'guru',
            ]
        );

        $guru2 = Pengguna::firstOrCreate(
            ['kode_login' => 'dewi'],
            [
                'nama_lengkap'  => 'Ibu Dewi Lestari, S.Pd (Guru Kelas TK)',
                'password_hash' => Hash::make('guru123'),
                'peran'         => 'guru',
            ]
        );

        // 3. Buat Akun Wali Murid
        $wali = Pengguna::firstOrCreate(
            ['kode_login' => 'wali'],
            [
                'nama_lengkap'  => 'Bpk. Ahmad Fauzi (Wali Murid)',
                'password_hash' => Hash::make('wali123'),
                'peran'         => 'walimurid',
            ]
        );

        // 4. Buat Contoh Data Anak
        $anak1 = Anak::firstOrCreate(
            ['nis' => 'PAUD-2026-001'],
            [
                'nama_anak'     => 'Muhammad Rayyan Fauzi',
                'tempat_lahir'  => 'Jakarta',
                'tanggal_lahir' => '2021-05-14',
                'jenis_kelamin' => 'L',
                'alamat'        => 'Jl. Haqqul Yaqin No. 12',
                'kelompok'      => 'Kelompok Bermain (KB)',
            ]
        );

        $anak2 = Anak::firstOrCreate(
            ['nis' => 'PAUD-2026-002'],
            [
                'nama_anak'     => 'Siti Aisyah Putri',
                'tempat_lahir'  => 'Jakarta',
                'tanggal_lahir' => '2020-08-20',
                'jenis_kelamin' => 'P',
                'alamat'        => 'Jl. Cendrawasih No. 5',
                'kelompok'      => 'TK A',
            ]
        );

        // 5. Hubungkan Anak dengan Wali Murid di tabel wali_anak
        DB::table('wali_anak')->updateOrInsert(
            [
                'id_pengguna' => $wali->id_pengguna,
                'id_anak'     => $anak1->id_anak,
            ],
            [
                'hubungan'    => 'ayah',
                'utama'       => 1,
            ]
        );

        // 6. Buat Periode Rapor Triwulan
        $periode1 = PeriodeRapor::firstOrCreate(
            ['nama_periode' => 'Triwulan 1', 'tahun_ajaran' => '2026/2027']
        );
        $periode2 = PeriodeRapor::firstOrCreate(
            ['nama_periode' => 'Triwulan 2', 'tahun_ajaran' => '2026/2027']
        );
        $periode3 = PeriodeRapor::firstOrCreate(
            ['nama_periode' => 'Triwulan 3', 'tahun_ajaran' => '2026/2027']
        );
        $periode4 = PeriodeRapor::firstOrCreate(
            ['nama_periode' => 'Triwulan 4', 'tahun_ajaran' => '2026/2027']
        );

        // 7. Buat Contoh Rapor Triwulan 1 (Status: diajukan oleh Guru, menunggu review & publish Kepala Sekolah)
        $raporRayyan = HeadRaport::firstOrCreate(
            [
                'id_anak'    => $anak1->id_anak,
                'id_periode' => $periode1->id_periode,
            ],
            [
                'dibuat_oleh'    => $guru1->id_pengguna,
                'status_rapor'   => 'diajukan',
                'dibuat_pada'    => now()->subDays(3)->format('Y-m-d H:i:s'),
                'diajukan_pada'  => now()->subDays(1)->format('Y-m-d H:i:s'),
            ]
        );

        // Isi bagian rapor (aspek penilaian PAUD)
        $bagianRayyan = [
            [
                'urutan'       => 1,
                'jenis_bagian' => 'narasi',
                'judul_bagian' => 'Nilai Agama dan Budi Pekerti',
                'isi_narasi'   => 'Rayyan menunjukkan perkembangan sangat baik dalam mengenal doa sehari-hari, mampu menirukan gerakan salat dengan tertib, dan selalu mengucap salam saat tiba di sekolah.',
            ],
            [
                'urutan'       => 2,
                'jenis_bagian' => 'narasi',
                'judul_bagian' => 'Jati Diri (Fisik Motorik & Sosial-Emosional)',
                'isi_narasi'   => 'Rayyan sangat aktif dan gembira saat bermain lempar tangkap bola. Mampu berbagi mainan dengan teman sekelas dan mengekspresikan perasaannya dengan santun.',
            ],
            [
                'urutan'       => 3,
                'jenis_bagian' => 'narasi',
                'judul_bagian' => 'Dasar Literasi, Sains & Seni',
                'isi_narasi'   => 'Rayyan antusias mendengarkan cerita guru, mampu menyebutkan warna-warna dasar dan bentuk geometri sederhana, serta gemar mewarnai pola alam.',
            ],
            [
                'urutan'       => 4,
                'jenis_bagian' => 'narasi',
                'judul_bagian' => 'Catatan dan Saran Guru Pendamping',
                'isi_narasi'   => 'Rayyan memiliki rasa ingin tahu yang tinggi. Disarankan di rumah untuk terus dibiasakan membacakan dongeng sebelum tidur guna memperkaya kosakata.',
            ],
        ];

        foreach ($bagianRayyan as $b) {
            BodyRaport::updateOrInsert(
                [
                    'id_rapor' => $raporRayyan->id_rapor,
                    'urutan'   => $b['urutan'],
                ],
                $b
            );
        }
    }
}
