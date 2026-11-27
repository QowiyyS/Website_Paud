<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'nomor_registrasi',
        'jalur',
        'program',

        // 1. Identitas Siswa
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'usia',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'anak_ke',
        'jumlah_saudara',
        'cita_cita',
        'hobby',
        'riwayat_penyakit',
        'makanan_dihindari',
        'minuman_dihindari',
        'alamat',

        // 2. Identitas Ayah
        'nama_ayah',
        'ttl_ayah',
        'pekerjaan_ayah',
        'pendidikan_ayah',
        'pendapatan_ayah',
        'usia_ayah',
        'alamat_ayah',
        'no_hp_ayah',

        // 3. Identitas Ibu
        'nama_ibu',
        'ttl_ibu',
        'pekerjaan_ibu',
        'pendidikan_ibu',
        'pendapatan_ibu',
        'usia_ibu',
        'alamat_ibu',
        'no_hp_ibu',

        // 4. Status & Admin
        'status',
        'catatan_admin',
        'id_anak',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Hubungkan pendaftaran dengan anak jika sudah terdaftar sebagai siswa aktif.
     */
    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class, 'id_anak', 'id_anak');
    }

    /**
     * Helper kontak utama (ayah atau ibu)
     */
    public function getKontakUtamaAttribute(): string
    {
        return $this->no_hp_ayah ?: ($this->no_hp_ibu ?: '-');
    }

    /**
     * Helper nama wali utama
     */
    public function getNamaWaliUtamaAttribute(): string
    {
        return $this->nama_ayah ?: ($this->nama_ibu ?: '-');
    }

    /**
     * Helper untuk label status
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Menunggu Verifikasi',
        };
    }

    /**
     * Helper untuk warna badge status Tailwind
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'diterima' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'ditolak' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-amber-100 text-amber-800 border-amber-300',
        };
    }

    /**
     * Helper format tanggal Indonesia
     */
    public function getTanggalLahirFormattedAttribute(): string
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }
        return $this->tanggal_lahir->translatedFormat('d F Y');
    }

    /**
     * Generate nomor registrasi baru otomatis
     */
    public static function generateNomorRegistrasi(string $program = 'PAUD'): string
    {
        $prefix = 'REG-' . strtoupper($program) . '-' . date('Ym');
        $latest = static::where('nomor_registrasi', 'like', "{$prefix}%")
            ->orderBy('id_pendaftaran', 'desc')
            ->first();

        if ($latest && preg_match('/-(\d{3,})$/', $latest->nomor_registrasi, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        return sprintf('%s-%03d', $prefix, $nextNumber);
    }
}
