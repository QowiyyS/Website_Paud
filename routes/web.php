<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\GuruManagementController;

// ================= RUTE PUBLIK =================
Route::view('/', 'landing.index')->name('landing');

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

    // Manajemen Guru & Staff Pengajar
    Route::resource('guru', GuruManagementController::class)->except(['show']);
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
