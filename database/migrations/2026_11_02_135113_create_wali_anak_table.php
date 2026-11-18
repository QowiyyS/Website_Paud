
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wali_anak', function (Blueprint $table) {
            $table->foreignId('id_pengguna')
                ->constrained('pengguna', 'id_pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_anak')
                ->constrained('anak', 'id_anak')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('hubungan');
            $table->integer('utama')->default(0);

            $table->primary(['id_pengguna', 'id_anak']);

            $table->index('id_anak', 'idx_wali_anak_anak');
        });

        DB::statement("
            CREATE TRIGGER wali_anak_check_insert
            BEFORE INSERT ON wali_anak
            FOR EACH ROW
            WHEN
                NEW.hubungan NOT IN ('ayah', 'ibu', 'wali')
                OR NEW.utama NOT IN (0, 1)
            BEGIN
                SELECT RAISE(ABORT, 'Data hubungan wali tidak valid');
            END
        ");

        DB::statement("
            CREATE TRIGGER wali_anak_check_update
            BEFORE UPDATE ON wali_anak
            FOR EACH ROW
            WHEN
                NEW.hubungan NOT IN ('ayah', 'ibu', 'wali')
                OR NEW.utama NOT IN (0, 1)
            BEGIN
                SELECT RAISE(ABORT, 'Data hubungan wali tidak valid');
            END
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS wali_anak_check_insert');
        DB::statement('DROP TRIGGER IF EXISTS wali_anak_check_update');

        Schema::dropIfExists('wali_anak');
    }
};
