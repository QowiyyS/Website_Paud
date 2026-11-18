
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_perubahan', function (Blueprint $table) {
            $table->id('id_riwayat');

            $table->foreignId('id_rapor')
                ->constrained('head_raport', 'id_rapor')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_blok')
                ->nullable()
                ->constrained('body_raport', 'id_blok')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_pengguna')
                ->constrained('pengguna', 'id_pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->text('isi_sebelum')->nullable();
            $table->text('isi_sesudah')->nullable();

            $table->text('waktu_perubahan')
                ->default(DB::raw("(datetime('now','localtime'))"));

            $table->index(
                ['id_rapor', 'waktu_perubahan'],
                'idx_riwayat_rapor_waktu'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_perubahan');
    }
};
