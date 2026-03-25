<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'nik_identitas',
        'nama_lengkap',
        'email',
        'rincian_informasi',
        'tujuan_penggunaan',
        'file_pendukung',
        'status'
    ];
}
