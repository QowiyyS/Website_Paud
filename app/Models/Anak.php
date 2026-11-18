<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Anak extends Model
{
    protected $table = 'anak';

    protected $primaryKey = 'id_anak';

    public $timestamps = false;

    protected $fillable = [
        'nis',
        'nama_anak',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kelompok',
    ];

    /**
     * Relasi anak dengan data rapor.
     */
    public function rapor(): HasMany
    {
        return $this->hasMany(
            HeadRaport::class,
            'id_anak',
            'id_anak'
        );
    }

    /**
     * Relasi anak dengan wali murid.
     */
    public function wali(): BelongsToMany
    {
        return $this->belongsToMany(
            Pengguna::class,
            'wali_anak',
            'id_anak',
            'id_pengguna',
            'id_anak',
            'id_pengguna'
        )
        ->using(WaliAnak::class)
        ->withPivot('hubungan', 'utama');
    }
}
