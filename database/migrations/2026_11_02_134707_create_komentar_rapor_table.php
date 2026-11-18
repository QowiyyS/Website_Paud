
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komentar_rapor', function (Blueprint $table) {
            $table->id('id_komentar');

            $table->foreignId('id_blok')
                ->constrained('body_raport', 'id_blok')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_pengguna')
                ->constrained('pengguna', 'id_pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
 
            $table->text('isi_komentar');
            $table->text('dibuat_pada')
                ->default(DB::raw("(datetime('now','localtime'))"));

            $table->string('status_komentar')->default('terbuka');
            $table->text('diselesaikan_pada')->nullable();

            $table->index(
                ['id_blok', 'status_komentar'],
                'idx_komentar_blok_status'
            );
        });

        DB::statement("
            CREATE TRIGGER komentar_rapor_check_insert
            BEFORE INSERT ON komentar_rapor
            FOR EACH ROW
            WHEN
                NEW.status_komentar NOT IN (
                    'terbuka',
                    'ditindaklanjuti',
                    'selesai'
                )
                OR (
                    NEW.status_komentar = 'selesai'
                    AND NEW.diselesaikan_pada IS NULL
                )
            BEGIN
                SELECT RAISE(ABORT, 'Status komentar tidak valid');
            END
        ");

        DB::statement("
            CREATE TRIGGER komentar_rapor_check_update
            BEFORE UPDATE ON komentar_rapor
            FOR EACH ROW
            WHEN
                NEW.status_komentar NOT IN (
                    'terbuka',
                    'ditindaklanjuti',
                    'selesai'
                )
                OR (
                    NEW.status_komentar = 'selesai'
                    AND NEW.diselesaikan_pada IS NULL
                )
            BEGIN
                SELECT RAISE(ABORT, 'Status komentar tidak valid');
            END
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS komentar_rapor_check_insert');
        DB::statement('DROP TRIGGER IF EXISTS komentar_rapor_check_update');

        Schema::dropIfExists('komentar_rapor');
    }
};
