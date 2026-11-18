<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPerubahan extends Model
{
    protected $table = 'riwayat_perubahan';

    protected $primaryKey = 'id_riwayat';

    public $timestamps = false;

    protected $fillable = [
        'id_rapor',
        'id_blok',
        'id_pengguna',
        'isi_sebelum',
        'isi_sesudah',
        'waktu_perubahan',
    ];

    /**
     * Relasi dengan rapor.
     */
    public function rapor(): BelongsTo
    {
        return $this->belongsTo(
            HeadRaport::class,
            'id_rapor',
            'id_rapor'
        );
    }

    /**
     * Relasi dengan bagian rapor yang mengalami perubahan.
     */
    public function bagian(): BelongsTo
    {
        return $this->belongsTo(
            BodyRaport::class,
            'id_blok',
            'id_blok'
        );
    }

    /**
     * Relasi dengan pengguna yang melakukan perubahan.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(
            Pengguna::class,
            'id_pengguna',
            'id_pengguna'
        );
    }
}
