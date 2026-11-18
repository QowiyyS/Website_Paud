
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anak', function (Blueprint $table) {
            $table->id('id_anak');

            $table->string('nis')->unique();
            $table->string('nama_anak');

            $table->string('tempat_lahir')->nullable();
            $table->text('tanggal_lahir')->nullable();

            $table->string('jenis_kelamin')->nullable();

            $table->text('alamat')->nullable();
            $table->string('kelompok')->nullable();

            $table->index('nama_anak', 'idx_anak_nama');
            $table->index('kelompok', 'idx_anak_kelompok');
        });

        DB::statement("
            CREATE TRIGGER anak_check_insert
            BEFORE INSERT ON anak
            FOR EACH ROW
            WHEN
                (
                    NEW.jenis_kelamin IS NOT NULL
                    AND NEW.jenis_kelamin NOT IN ('L', 'P')
                )
                OR (
                    NEW.tanggal_lahir IS NOT NULL
                    AND (
                        date(NEW.tanggal_lahir) IS NULL
                        OR date(NEW.tanggal_lahir) <> NEW.tanggal_lahir
                    )
                )
            BEGIN
                SELECT RAISE(ABORT, 'Data anak tidak valid');
            END
        ");

        DB::statement("
            CREATE TRIGGER anak_check_update
            BEFORE UPDATE ON anak
            FOR EACH ROW
            WHEN
                (
                    NEW.jenis_kelamin IS NOT NULL
                    AND NEW.jenis_kelamin NOT IN ('L', 'P')
                )
                OR (
                    NEW.tanggal_lahir IS NOT NULL
                    AND (
                        date(NEW.tanggal_lahir) IS NULL
                        OR date(NEW.tanggal_lahir) <> NEW.tanggal_lahir
                    )
                )
            BEGIN
                SELECT RAISE(ABORT, 'Data anak tidak valid');
            END
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS anak_check_insert');
        DB::statement('DROP TRIGGER IF EXISTS anak_check_update');

        Schema::dropIfExists('anak');
    }
};
