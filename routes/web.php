<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnakController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PeriodeRaporController;
use App\Http\Controllers\Admin\WaliAnakController;
use App\Http\Controllers\Admin\RaporAdminController;

Route::view('/', 'landing.index')->name('landing');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Master
    Route::resource('anak', AnakController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('periode', PeriodeRaporController::class);

    // Relasi Wali - Anak
    Route::post('wali-anak', [WaliAnakController::class, 'store'])->name('wali-anak.store');
    Route::delete('wali-anak/{id_pengguna}/{id_anak}', [WaliAnakController::class, 'destroy'])->name('wali-anak.destroy');

    // Kontrol Persetujuan & Penerbitan Rapor
    Route::get('rapor', [RaporAdminController::class, 'index'])->name('rapor.index');
    Route::get('rapor/{id_rapor}', [RaporAdminController::class, 'show'])->name('rapor.show');
    Route::post('rapor/{id_rapor}/setujui', [RaporAdminController::class, 'setujui'])->name('rapor.setujui');
    Route::post('rapor/{id_rapor}/terbitkan', [RaporAdminController::class, 'terbitkan'])->name('rapor.terbitkan');
    Route::post('rapor/{id_rapor}/buka-ulang', [RaporAdminController::class, 'bukaUlang'])->name('rapor.buka-ulang');
});