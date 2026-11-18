<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeRapor extends Model
{
    protected $table = 'periode_rapor';

    protected $primaryKey = 'id_periode';

    public $timestamps = false;

    protected $fillable = [
        'nama_periode',
        'tahun_ajaran',
    ];

    /**
     * Relasi periode dengan data rapor.
     */
    public function rapor(): HasMany
    {
        return $this->hasMany(
            HeadRaport::class,
            'id_periode',
            'id_periode'
        );
    }
}
