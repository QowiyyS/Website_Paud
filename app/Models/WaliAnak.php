<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WaliAnak extends Pivot
{
    protected $table = 'wali_anak';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'id_anak',
        'hubungan',
        'utama',
    ];
}
