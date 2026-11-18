
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_raport', function (Blueprint $table) {
            $table->id('id_blok');

            $table->foreignId('id_rapor')
                ->constrained('head_raport', 'id_rapor')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('jenis_bagian');

            $table->string('judul_bagian')->nullable();
            $table->text('isi_narasi')->nullable();

            $table->integer('urutan');

            $table->string('lokasi_file')->nullable();
            $table->text('caption')->nullable();

            $table->unique(
                ['id_rapor', 'urutan'],
                'body_raport_urutan_unique'
            );

            $table->index(
                ['id_rapor', 'urutan'],
                'idx_body_rapor_urutan'
            );
        });

        DB::statement("
            CREATE TRIGGER body_raport_check_insert
            BEFORE INSERT ON body_raport
            FOR EACH ROW
            WHEN
                NEW.jenis_bagian NOT IN ('narasi', 'dokumentasi')
                OR NEW.urutan IS NULL
                OR NEW.urutan < 1
                OR (
                    NEW.jenis_bagian = 'narasi'
                    AND NEW.lokasi_file IS NOT NULL
                )
                OR (
                    NEW.jenis_bagian = 'dokumentasi'
                    AND (
                        NEW.lokasi_file IS NULL
                        OR NEW.isi_narasi IS NOT NULL
                    )
                )
            BEGIN
                SELECT RAISE(ABORT, 'Struktur bagian rapor tidak valid');
            END
        ");

        DB::statement("
            CREATE TRIGGER body_raport_check_update
            BEFORE UPDATE ON body_raport
            FOR EACH ROW
            WHEN
                NEW.jenis_bagian NOT IN ('narasi', 'dokumentasi')
                OR NEW.urutan IS NULL
                OR NEW.urutan < 1
                OR (
                    NEW.jenis_bagian = 'narasi'
                    AND NEW.lokasi_file IS NOT NULL
                )
                OR (
                    NEW.jenis_bagian = 'dokumentasi'
                    AND (
                        NEW.lokasi_file IS NULL
                        OR NEW.isi_narasi IS NOT NULL
                    )
                )
            BEGIN
                SELECT RAISE(ABORT, 'Struktur bagian rapor tidak valid');
            END
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS body_raport_check_insert');
        DB::statement('DROP TRIGGER IF EXISTS body_raport_check_update');

        Schema::dropIfExists('body_raport');
    }
};
