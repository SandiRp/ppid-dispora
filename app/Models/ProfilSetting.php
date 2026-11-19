<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'judul',
        'konten',
        'gambar',
    ];

    /**
     * Helper untuk mengambil data setting profil berdasarkan key
     */
    public static function getByKey(string $key, ?string $default = null): ?self
    {
        return self::where('key', $key)->first();
    }
}
