
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('kode_login')->unique();
            $table->string('nama_lengkap');
            $table->string('password_hash');
            $table->string('peran');

            $table->index('peran', 'idx_pengguna_peran');
        });

        DB::unprepared("
            CREATE TRIGGER trg_pengguna_peran_insert
            BEFORE INSERT ON pengguna
            FOR EACH ROW
            BEGIN
                SELECT CASE
                    WHEN NEW.peran NOT IN (
                        'admin',
                        'guru',
                        'walimurid',
                        'admin_guru'
                    )
                    THEN RAISE(ABORT, 'Peran pengguna tidak valid')
                END;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_pengguna_peran_update
            BEFORE UPDATE ON pengguna
            FOR EACH ROW
            BEGIN
                SELECT CASE
                    WHEN NEW.peran NOT IN (
                        'admin',
                        'guru',
                        'walimurid',
                        'admin_guru'
                    )
                    THEN RAISE(ABORT, 'Peran pengguna tidak valid')
                END;
            END;
        ");

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_pengguna_peran_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_pengguna_peran_update');

        Schema::dropIfExists('sessions');
        Schema::dropIfExists('pengguna');
    }
};
