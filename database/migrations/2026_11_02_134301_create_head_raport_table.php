
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('head_raport', function (Blueprint $table) {
            $table->id('id_rapor');

            $table->foreignId('id_anak')
                ->constrained('anak', 'id_anak')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_periode')
                ->constrained('periode_rapor', 'id_periode')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('dibuat_oleh')
                ->constrained('pengguna', 'id_pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('diperiksa_oleh')
                ->nullable()
                ->constrained('pengguna', 'id_pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('diterbitkan_oleh')
                ->nullable()
                ->constrained('pengguna', 'id_pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('status_rapor')->default('draf');

            $table->text('dibuat_pada')
                ->default(DB::raw("(datetime('now','localtime'))"));

            $table->text('diajukan_pada')->nullable();
            $table->text('diterbitkan_pada')->nullable();

            $table->foreignId('disetujui_oleh')
                ->nullable()
                ->constrained('pengguna', 'id_pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->text('disetujui_pada')->nullable();

            $table->unique(
                ['id_anak', 'id_periode'],
                'head_raport_anak_periode_unique'
            );

            $table->index('status_rapor', 'idx_rapor_status');

            $table->index(
                ['id_anak', 'id_periode'],
                'idx_rapor_anak_periode'
            );
        });

        DB::statement("
            CREATE TRIGGER head_raport_check_approval_insert
            BEFORE INSERT ON head_raport
            FOR EACH ROW
            WHEN NEW.status_rapor IN ('disetujui', 'diterbitkan')
            AND (NEW.disetujui_oleh IS NULL OR NEW.disetujui_pada IS NULL)
            BEGIN
                SELECT RAISE(ABORT, 'Rapor harus disetujui terlebih dahulu');
            END
        ");

        DB::statement("
            CREATE TRIGGER head_raport_check_publication_insert
            BEFORE INSERT ON head_raport
            FOR EACH ROW
            WHEN NEW.status_rapor = 'diterbitkan'
            AND (NEW.diterbitkan_oleh IS NULL OR NEW.diterbitkan_pada IS NULL)
            BEGIN
                SELECT RAISE(ABORT, 'Data penerbitan rapor belum lengkap');
            END
        ");

        DB::statement("
            CREATE TRIGGER head_raport_check_approval_update
            BEFORE UPDATE ON head_raport
            FOR EACH ROW
            WHEN NEW.status_rapor IN ('disetujui', 'diterbitkan')
            AND (NEW.disetujui_oleh IS NULL OR NEW.disetujui_pada IS NULL)
            BEGIN
                SELECT RAISE(ABORT, 'Rapor harus disetujui terlebih dahulu');
            END
        ");

        DB::statement("
            CREATE TRIGGER head_raport_check_publication_update
            BEFORE UPDATE ON head_raport
            FOR EACH ROW
            WHEN NEW.status_rapor = 'diterbitkan'
            AND (NEW.diterbitkan_oleh IS NULL OR NEW.diterbitkan_pada IS NULL)
            BEGIN
                SELECT RAISE(ABORT, 'Data penerbitan rapor belum lengkap');
            END
        ");

        DB::statement("
            CREATE TRIGGER head_raport_check_status_insert
            BEFORE INSERT ON head_raport
            FOR EACH ROW
            WHEN NEW.status_rapor NOT IN (
                'draf',
                'diajukan',
                'perlu_revisi',
                'disetujui',
                'diterbitkan'
            )
            BEGIN
                SELECT RAISE(ABORT, 'Status rapor tidak valid');
            END
        ");

        DB::statement("
            CREATE TRIGGER head_raport_check_status_update
            BEFORE UPDATE ON head_raport
            FOR EACH ROW
            WHEN NEW.status_rapor NOT IN (
                'draf',
                'diajukan',
                'perlu_revisi',
                'disetujui',
                'diterbitkan'
            )
            BEGIN
                SELECT RAISE(ABORT, 'Status rapor tidak valid');
            END
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS head_raport_check_approval_insert');
        DB::statement('DROP TRIGGER IF EXISTS head_raport_check_publication_insert');
        DB::statement('DROP TRIGGER IF EXISTS head_raport_check_approval_update');
        DB::statement('DROP TRIGGER IF EXISTS head_raport_check_publication_update');
        DB::statement('DROP TRIGGER IF EXISTS head_raport_check_status_insert');
        DB::statement('DROP TRIGGER IF EXISTS head_raport_check_status_update');

        Schema::dropIfExists('head_raport');
    }
};
