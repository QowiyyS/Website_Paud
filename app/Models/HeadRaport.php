<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeadRaport extends Model
{
    protected $table = 'head_raport';

    protected $primaryKey = 'id_rapor';

    public $timestamps = false;

    protected $fillable = [
        'id_anak',
        'id_periode',
        'dibuat_oleh',
        'diperiksa_oleh',
        'diterbitkan_oleh',
        'status_rapor',
        'dibuat_pada',
        'diajukan_pada',
        'diterbitkan_pada',
        'disetujui_oleh',
        'disetujui_pada',
    ];

    /**
     * Relasi rapor dengan anak.
     */
    public function anak(): BelongsTo
    {
        return $this->belongsTo(
            Anak::class,
            'id_anak',
            'id_anak'
        );
    }

    /**
     * Relasi rapor dengan periode.
     */
    public function periode(): BelongsTo
    {
        return $this->belongsTo(
            PeriodeRapor::class,
            'id_periode',
            'id_periode'
        );
    }

    /**
     * Pengguna yang membuat rapor.
     */
    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(
            Pengguna::class,
            'dibuat_oleh',
            'id_pengguna'
        );
    }

    /**
     * Pengguna yang memeriksa rapor.
     */
    public function pemeriksa(): BelongsTo
    {
        return $this->belongsTo(
            Pengguna::class,
            'diperiksa_oleh',
            'id_pengguna'
        );
    }

    /**
     * Pengguna yang menerbitkan rapor.
     */
    public function penerbit(): BelongsTo
    {
        return $this->belongsTo(
            Pengguna::class,
            'diterbitkan_oleh',
            'id_pengguna'
        );
    }

    /**
     * Pengguna yang menyetujui rapor.
     */
    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(
            Pengguna::class,
            'disetujui_oleh',
            'id_pengguna'
        );
    }

    /**
     * Relasi rapor dengan isi atau blok rapor.
     */
    public function bagian(): HasMany
    {
        return $this->hasMany(
            BodyRaport::class,
            'id_rapor',
            'id_rapor'
        );
    }

    /**
     * Alias relasi blok rapor (untuk kompatibilitas controller admin).
     */
    public function blok(): HasMany
    {
        return $this->bagian();
    }

    /**
     * Relasi rapor dengan riwayat perubahan.
     */
    public function riwayatPerubahan(): HasMany
    {
        return $this->hasMany(
            RiwayatPerubahan::class,
            'id_rapor',
            'id_rapor'
        );
    }

    /**
     * Alias relasi riwayat rapor (untuk kompatibilitas controller admin).
     */
    public function riwayat(): HasMany
    {
        return $this->riwayatPerubahan();
    }
}
