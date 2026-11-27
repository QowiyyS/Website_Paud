<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->string('nomor_registrasi')->unique();
            $table->string('jalur')->default('online'); // online, offline
            $table->string('program'); // KB, TK

            // 1. IDENTITAS SISWA (SESUAI DOKUMEN RESMI FORMULIR PENDAFTARAN)
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 1); // L, P
            $table->string('usia')->nullable();
            $table->string('berat_badan')->nullable(); // dalam kg
            $table->string('tinggi_badan')->nullable(); // dalam cm
            $table->string('lingkar_kepala')->nullable(); // dalam cm
            $table->unsignedSmallInteger('anak_ke')->nullable();
            $table->unsignedSmallInteger('jumlah_saudara')->nullable();
            $table->string('cita_cita')->nullable();
            $table->string('hobby')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->text('makanan_dihindari')->nullable();
            $table->text('minuman_dihindari')->nullable();
            $table->text('alamat')->nullable();

            // 2. IDENTITAS ORANG TUA / WALI MURID - AYAH
            $table->string('nama_ayah')->nullable();
            $table->string('ttl_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pendapatan_ayah')->nullable();
            $table->string('usia_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();

            // 3. IDENTITAS ORANG TUA / WALI MURID - IBU
            $table->string('nama_ibu')->nullable();
            $table->string('ttl_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pendapatan_ibu')->nullable();
            $table->string('usia_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();

            // 4. DATA ADMINISTRASI & STATUS
            $table->string('status')->default('menunggu'); // menunggu, diterima, ditolak
            $table->text('catatan_admin')->nullable();
            $table->unsignedBigInteger('id_anak')->nullable();

            $table->timestamps();

            $table->index('nomor_registrasi');
            $table->index('status');
            $table->index('program');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
