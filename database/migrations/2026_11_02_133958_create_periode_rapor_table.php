
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_rapor', function (Blueprint $table) {
            $table->id('id_periode');

            $table->string('nama_periode');

            $table->string('tahun_ajaran');

            $table->unique(
                ['nama_periode', 'tahun_ajaran'],
                'periode_rapor_nama_tahun_unique'
            );
        });

        DB::statement("
            CREATE TRIGGER periode_rapor_check_insert
            BEFORE INSERT ON periode_rapor
            FOR EACH ROW
            WHEN NEW.nama_periode NOT IN ('Semester 1', 'Semester 2')
            BEGIN
                SELECT RAISE(ABORT, 'Nama periode tidak valid');
            END
        ");

        DB::statement("
            CREATE TRIGGER periode_rapor_check_update
            BEFORE UPDATE ON periode_rapor
            FOR EACH ROW
            WHEN NEW.nama_periode NOT IN ('Semester 1', 'Semester 2')
            BEGIN
                SELECT RAISE(ABORT, 'Nama periode tidak valid');
            END
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS periode_rapor_check_insert');
        DB::statement('DROP TRIGGER IF EXISTS periode_rapor_check_update');

        Schema::dropIfExists('periode_rapor');
    }
};
