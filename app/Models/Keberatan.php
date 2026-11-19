<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Keberatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'nomor_keberatan',
        'nama_pemohon',
        'email',
        'nomor_telepon',
        'alasan_keberatan',
        'keterangan_keberatan',
        'file_pendukung',
        'status',
        'tanggapan_atasan_ppid',
        'tanggal_tanggapan'
    ];

    protected $casts = [
        'tanggal_tanggapan' => 'datetime',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    /**
     * Hitung sisa hari kerja berdasarkan SLA Pasal 36 ayat (1) UU 14/2008 (30 hari kerja)
     */
    public function getSlaInfoAttribute(): array
    {
        if (in_array($this->status, ['selesai', 'ditolak'])) {
            return [
                'days_left' => 0,
                'status_sla' => 'completed',
                'label' => 'Sudah Ditanggapi',
            ];
        }

        $createdAt = $this->created_at ? $this->created_at->copy() : now();
        $targetDate = $this->addBusinessDays($createdAt, 30);
        $today = now()->startOfDay();

        $diff = $this->countBusinessDaysBetween($today, $targetDate);

        if ($today->gt($targetDate)) {
            $overdueDays = $this->countBusinessDaysBetween($targetDate, $today);
            return [
                'days_left' => -$overdueDays,
                'status_sla' => 'expired',
                'label' => 'Terlambat ' . $overdueDays . ' hari kerja',
            ];
        } elseif ($diff <= 5) {
            return [
                'days_left' => $diff,
                'status_sla' => 'warning',
                'label' => 'Sisa ' . $diff . ' hari kerja',
            ];
        } else {
            return [
                'days_left' => $diff,
                'status_sla' => 'normal',
                'label' => 'Sisa ' . $diff . ' hari kerja',
            ];
        }
    }

    protected function addBusinessDays(Carbon $date, int $days): Carbon
    {
        $d = $date->copy();
        while ($days > 0) {
            $d->addDay();
            if (!$d->isWeekend()) {
                $days--;
            }
        }
        return $d->endOfDay();
    }

    protected function countBusinessDaysBetween(Carbon $start, Carbon $end): int
    {
        if ($start->gte($end)) {
            return 0;
        }

        $curr = $start->copy();
        $count = 0;
        while ($curr->lt($end)) {
            $curr->addDay();
            if (!$curr->isWeekend() && $curr->lte($end)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Generate format nomor keberatan: KEB-YYYYMM-0001
     */
    public static function generateNomorKeberatan(): string
    {
        $prefix = 'KEB-' . date('Ym') . '-';
        $latest = self::where('nomor_keberatan', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($latest && preg_match('/-(\d+)$/', $latest->nomor_keberatan, $matches)) {
            $number = intval($matches[1]) + 1;
        } else {
            $number = 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
