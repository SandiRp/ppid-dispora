<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ringkasan_informasi',
        'deskripsi',
        'penanggung_jawab',
        'tahun',
        'format',
        'file_dokumen',
        'kategori'
    ];
}
