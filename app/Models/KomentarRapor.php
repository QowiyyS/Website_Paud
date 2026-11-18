<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomentarRapor extends Model
{
    protected $table = 'komentar_rapor';

    protected $primaryKey = 'id_komentar';

    public $timestamps = false;

    protected $fillable = [
        'id_blok',
        'id_pengguna',
        'isi_komentar',
        'dibuat_pada',
        'status_komentar',
        'diselesaikan_pada',
    ];

    /**
     * Relasi komentar dengan bagian rapor.
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
     * Relasi komentar dengan pengguna yang memberikan komentar.
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
