<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'kode_login',
        'nama_lengkap',
        'password_hash',
        'peran',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public $timestamps = false;

    /**
     * Nama kolom password untuk autentikasi Laravel.
     */
    protected $authPasswordName = 'password_hash';

    /**
     * Mengembalikan password hash untuk autentikasi Laravel.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function isAdmin(): bool
    {
        return in_array($this->peran, ['admin', 'admin_guru']);
    }

    public function isGuru(): bool
    {
        return in_array($this->peran, ['guru', 'admin_guru', 'admin']);
    }

    public function isWali(): bool
    {
        return $this->peran === 'walimurid';
    }

    /**
     * Relasi pengguna dengan anak yang terhubung.
     */
    public function anak(): BelongsToMany
    {
        return $this->belongsToMany(
            Anak::class,
            'wali_anak',
            'id_pengguna',
            'id_anak',
            'id_pengguna',
            'id_anak'
        )
        ->using(WaliAnak::class)
        ->withPivot('hubungan', 'utama');
    }

    /**
     * Relasi pengguna dengan komentar yang dibuat.
     */
    public function komentar(): HasMany
    {
        return $this->hasMany(
            KomentarRapor::class,
            'id_pengguna',
            'id_pengguna'
        );
    }

    /**
     * Rapor yang dibuat oleh pengguna.
     */
    public function raporDibuat(): HasMany
    {
        return $this->hasMany(
            HeadRaport::class,
            'dibuat_oleh',
            'id_pengguna'
        );
    }

    /**
     * Rapor yang diperiksa oleh pengguna.
     */
    public function raporDiperiksa(): HasMany
    {
        return $this->hasMany(
            HeadRaport::class,
            'diperiksa_oleh',
            'id_pengguna'
        );
    }

    /**
     * Rapor yang diterbitkan oleh pengguna.
     */
    public function raporDiterbitkan(): HasMany
    {
        return $this->hasMany(
            HeadRaport::class,
            'diterbitkan_oleh',
            'id_pengguna'
        );
    }

    /**
     * Rapor yang disetujui oleh pengguna.
     */
    public function raporDisetujui(): HasMany
    {
        return $this->hasMany(
            HeadRaport::class,
            'disetujui_oleh',
            'id_pengguna'
        );
    }
}
