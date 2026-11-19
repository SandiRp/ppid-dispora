<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'nama_responden',
        'email_responden',
        'kesesuaian_persyaratan',
        'kemudahan_prosedur',
        'kecepatan_waktu',
        'kewajaran_biaya',
        'kesesuaian_produk',
        'kompetensi_petugas',
        'kesopanan_petugas',
        'kualitas_sarana',
        'penanganan_pengaduan',
        'skor_rata_rata',
        'nilai_ikm',
        'saran_masukan'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    /**
     * Menghitung mutu pelayanan berdasarkan nilai IKM (Permenpan RB 14/2017)
     */
    public function getMutuPelayananAttribute(): string
    {
        $ikm = $this->nilai_ikm;
        if ($ikm >= 88.31) return 'Sangat Baik (A)';
        if ($ikm >= 76.61) return 'Baik (B)';
        if ($ikm >= 65.00) return 'Kurang Baik (C)';
        return 'Tidak Baik (D)';
    }
}
