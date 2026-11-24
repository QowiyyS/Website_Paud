<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS periode_rapor_check_insert');
        DB::statement('DROP TRIGGER IF EXISTS periode_rapor_check_update');

        DB::statement("
            CREATE TRIGGER periode_rapor_check_insert
            BEFORE INSERT ON periode_rapor
            FOR EACH ROW
            WHEN NEW.nama_periode NOT IN ('Triwulan 1', 'Triwulan 2', 'Triwulan 3', 'Triwulan 4', 'Semester 1', 'Semester 2')
            BEGIN
                SELECT RAISE(ABORT, 'Nama periode tidak valid');
            END
        ");

        DB::statement("
            CREATE TRIGGER periode_rapor_check_update
            BEFORE UPDATE ON periode_rapor
            FOR EACH ROW
            WHEN NEW.nama_periode NOT IN ('Triwulan 1', 'Triwulan 2', 'Triwulan 3', 'Triwulan 4', 'Semester 1', 'Semester 2')
            BEGIN
                SELECT RAISE(ABORT, 'Nama periode tidak valid');
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS periode_rapor_check_insert');
        DB::statement('DROP TRIGGER IF EXISTS periode_rapor_check_update');

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
};
