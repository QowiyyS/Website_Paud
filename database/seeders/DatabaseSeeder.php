<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna (Kepala Sekolah/Admin, Guru KB, Guru TK, Wali Murid)
        DB::table('pengguna')->insert([
            [
                'kode_login' => 'a001',
                'nama_lengkap' => 'Nurva Aghniatri Fadhila, S.Pd.',
                'password_hash' => Hash::make('admin123'),
                'peran' => 'admin',
            ],
            [
                'kode_login' => 'g001',
                'nama_lengkap' => 'Miss Tata',
                'password_hash' => Hash::make('guru123'),
                'peran' => 'guru',
            ],
            [
                'kode_login' => 'g002',
                'nama_lengkap' => 'Miss Zeda',
                'password_hash' => Hash::make('guru123'),
                'peran' => 'guru',
            ],
            [
                'kode_login' => 'w001',
                'nama_lengkap' => 'Wali Aisha Adeline Afany',
                'password_hash' => Hash::make('wali123'),
                'peran' => 'walimurid',
            ],
        ]);

        // 2. Periode Rapor
        DB::table('periode_rapor')->insert([
            [
                'nama_periode' => 'Semester 1',
                'tahun_ajaran' => '2026/2027',
            ],
        ]);

        // 3. Data Siswa KB (11 Anak) & TK (4 Anak) PAUD Haqqul Yaqin
        DB::table('anak')->insert([
            // --- KELOMPOK BERMAIN (KB) ---
            [
                'nis' => 'KB2026001',
                'nama_anak' => 'Aisha Adeline Afany',
                'tempat_lahir' => 'Magelang',
                'tanggal_lahir' => '2022-11-06',
                'jenis_kelamin' => 'P',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026002',
                'nama_anak' => 'Ardanico Hamzah Dewananda',
                'tempat_lahir' => 'Kota Magelang',
                'tanggal_lahir' => '2023-05-29',
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026003',
                'nama_anak' => 'Arshaka Bara Abdullah',
                'tempat_lahir' => 'Magelang',
                'tanggal_lahir' => '2023-05-28',
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026004',
                'nama_anak' => 'Ibrahim Faza Wibawa',
                'tempat_lahir' => 'Magelang',
                'tanggal_lahir' => '2023-07-25',
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026005',
                'nama_anak' => 'Kenzo Anoraga Al Karim',
                'tempat_lahir' => 'Kota Magelang',
                'tanggal_lahir' => '2023-05-17',
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026006',
                'nama_anak' => 'Pranaja Barata Albama',
                'tempat_lahir' => 'Magelang',
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026007',
                'nama_anak' => 'Zio',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026008',
                'nama_anak' => 'Jenna',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'P',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026009',
                'nama_anak' => 'Luiz',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026010',
                'nama_anak' => 'Rafasha',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'KB',
            ],
            [
                'nis' => 'KB2026011',
                'nama_anak' => 'Zea',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'P',
                'alamat' => null,
                'kelompok' => 'KB',
            ],

            // --- TAMAN KANAK-KANAK (TK) ---
            [
                'nis' => 'TK2026001',
                'nama_anak' => 'Ardin Alirohib Dewanto',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2021-02-27',
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'TK',
            ],
            [
                'nis' => 'TK2026002',
                'nama_anak' => 'Qiana Aulia Hafizah',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2021-08-25',
                'jenis_kelamin' => 'P',
                'alamat' => null,
                'kelompok' => 'TK',
            ],
            [
                'nis' => 'TK2026003',
                'nama_anak' => 'Sahila',
                'tempat_lahir' => 'Magelang',
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'P',
                'alamat' => null,
                'kelompok' => 'TK',
            ],
            [
                'nis' => 'TK2026004',
                'nama_anak' => 'Riswan',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'L',
                'alamat' => null,
                'kelompok' => 'TK',
            ],
        ]);

        // 4. Contoh Relasi Wali-Anak (w001 -> Aisha Adeline Afany)
        DB::table('wali_anak')->insert([
            [
                'id_pengguna' => 4,
                'id_anak' => 1,
                'hubungan' => 'ibu',
                'utama' => 1,
            ],
        ]);
    }
}