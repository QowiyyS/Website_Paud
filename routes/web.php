<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\GuruManagementController;
use App\Http\Controllers\Admin\AnakController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PeriodeRaporController;
use App\Http\Controllers\Admin\WaliAnakController;
use App\Http\Controllers\Admin\RaporAdminController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\PendaftaranController;

// ================= RUTE PUBLIK =================
Route::view('/', 'landing.index')->name('landing');

// Alur Pendaftaran Online Siswa Baru
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/berhasil/{nomor}', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');

// Autentikasi (Login & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ================= RUTE RAPOR (GURU & KEPALA SEKOLAH) =================
Route::middleware(['auth', 'peran:admin,admin_guru,guru'])->prefix('rapor')->name('rapor.')->group(function () {
    Route::get('/', [RaporController::class, 'index'])->name('index');
    Route::get('/buat', [RaporController::class, 'create'])->name('create');
    Route::post('/', [RaporController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RaporController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RaporController::class, 'update'])->name('update');
});

// Detail / Cetak Rapor (Admin, Guru, & Wali Murid dengan validasi status 'diterbitkan')
Route::middleware(['auth'])->get('/rapor/{id}', [RaporController::class, 'show'])->name('rapor.show');


// ================= RUTE ADMIN / KEPALA SEKOLAH =================
// Hanya bisa diakses oleh akun dengan peran 'admin' atau 'admin_guru'
Route::middleware(['auth', 'peran:admin,admin_guru'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manajemen Guru & Staf Pengajar
    Route::resource('guru', GuruManagementController::class)->except(['show']);

    // Master Data Siswa KB & TK (POV Admin)
    Route::resource('anak', AnakController::class);

    // Master Akun Pengguna & Wali Murid (POV Admin)
    Route::resource('pengguna', PenggunaController::class);

    // Relasi Penautan Wali Murid ke Anak (POV Admin)
    Route::post('wali-anak', [WaliAnakController::class, 'store'])->name('wali-anak.store');
    Route::delete('wali-anak/{id_pengguna}/{id_anak}', [WaliAnakController::class, 'destroy'])->name('wali-anak.destroy');

    // Master Periode Rapor & Tahun Ajaran (POV Admin)
    Route::resource('periode', PeriodeRaporController::class);

    // Manajemen Pendaftaran Online (PPDB)
    Route::get('pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::put('pendaftaran/{pendaftaran}/status', [AdminPendaftaranController::class, 'updateStatus'])->name('pendaftaran.update-status');
    Route::post('pendaftaran/{pendaftaran}/jadikan-siswa', [AdminPendaftaranController::class, 'jadikanSiswa'])->name('pendaftaran.jadikan-siswa');
    Route::delete('pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

    // Kontrol Persetujuan, Penerbitan, dan Pembukaan Ulang Rapor (POV Admin)
    Route::get('rapor', [RaporAdminController::class, 'index'])->name('rapor.index');
    Route::get('rapor/{id_rapor}', [RaporAdminController::class, 'show'])->name('rapor.show');
    Route::post('rapor/{id_rapor}/setujui', [RaporAdminController::class, 'setujui'])->name('rapor.setujui');
    Route::post('rapor/{id_rapor}/terbitkan', [RaporAdminController::class, 'terbitkan'])->name('rapor.terbitkan');
    Route::post('rapor/{id_rapor}/buka-ulang', [RaporAdminController::class, 'bukaUlang'])->name('rapor.buka-ulang');
});


// ================= RUTE GURU / STAFF PENDIDIK =================
// Hanya bisa diakses oleh 'guru', 'admin_guru', atau 'admin'
Route::middleware(['auth', 'peran:guru,admin_guru,admin'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('dashboard');
});


// ================= RUTE WALI MURID =================
// Hanya bisa diakses oleh 'walimurid'
Route::middleware(['auth', 'peran:walimurid'])->prefix('wali')->name('wali.')->group(function () {
    Route::get('/dashboard', [WaliController::class, 'index'])->name('dashboard');
});
