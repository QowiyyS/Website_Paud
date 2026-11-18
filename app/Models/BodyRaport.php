<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BodyRaport extends Model
{
    protected $table = 'body_raport';

    protected $primaryKey = 'id_blok';

    public $timestamps = false;

    protected $fillable = [
        'id_rapor',
        'jenis_bagian',
        'judul_bagian',
        'isi_narasi',
        'urutan',
        'lokasi_file',
        'caption',
    ];

    /**
     * Relasi bagian rapor dengan data utama rapor.
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
     * Relasi bagian rapor dengan komentar.
     */
    public function komentar(): HasMany
    {
        return $this->hasMany(
            KomentarRapor::class,
            'id_blok',
            'id_blok'
        );
    }

    /**
     * Relasi bagian rapor dengan riwayat perubahan.
     */
    public function riwayatPerubahan(): HasMany
    {
        return $this->hasMany(
            RiwayatPerubahan::class,
            'id_blok',
            'id_blok'
        );
    }
}
