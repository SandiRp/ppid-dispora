<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'module',
        'reference_id',
        'description',
        'ip_address',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper cepat untuk mencatat audit log
     */
    public static function record(string $action, string $module, string $description, ?string $referenceId = null): void
    {
        try {
            $user = auth()->user();
            self::create([
                'user_id' => $user?->id,
                'user_name' => $user ? $user->name : 'Sistem / Tamu',
                'action' => strtoupper($action),
                'module' => strtolower($module),
                'reference_id' => $referenceId,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mencatat audit log: ' . $e->getMessage());
        }
    }
}
