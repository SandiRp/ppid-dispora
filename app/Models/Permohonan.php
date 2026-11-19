<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_registrasi',
        'kategori',
        'tipe_permohonan',
        'petugas_pencatat',
        'is_disabilitas',
        'ragam_disabilitas',
        'format_jawaban_khusus',
        'kebutuhan_khusus',
        'nik_identitas',
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'rincian_informasi',
        'tujuan_penggunaan',
        'file_pendukung',
        'status',
        'catatan_admin',
        'alasan_penolakan',
        'file_jawaban',
        'tanggal_respon',
        'perpanjangan_sla',
        'alasan_perpanjangan',
        'tanggal_perpanjangan',
    ];

    protected $casts = [
        'is_disabilitas' => 'boolean',
        'perpanjangan_sla' => 'boolean',
        'tanggal_respon' => 'datetime',
        'tanggal_perpanjangan' => 'datetime',
    ];

    public function keberatans()
    {
        return $this->hasMany(Keberatan::class);
    }

    public function surveis()
    {
        return $this->hasMany(Survei::class);
    }

    /**
     * Hitung sisa hari kerja berdasarkan SLA UU 14/2008 (10 hari kerja + 7 hari kerja jika diperpanjang)
     * Mengembalikan array [ 'days_left' => int, 'status_sla' => 'normal'|'warning'|'expired', 'label' => string, 'is_extended' => bool ]
     */
    public function getSlaInfoAttribute(): array
    {
        if (in_array($this->status, ['selesai', 'ditolak'])) {
            return [
                'days_left' => 0,
                'status_sla' => 'completed',
                'label' => 'Sudah Direspons',
                'is_extended' => (bool)$this->perpanjangan_sla,
            ];
        }

        $createdAt = $this->created_at ? $this->created_at->copy() : now();
        $totalSlaDays = $this->perpanjangan_sla ? 17 : 10;
        $targetDate = $this->addBusinessDays($createdAt, $totalSlaDays);
        $today = now()->startOfDay();

        $diff = $this->countBusinessDaysBetween($today, $targetDate);

        if ($today->gt($targetDate)) {
            $overdueDays = $this->countBusinessDaysBetween($targetDate, $today);
            return [
                'days_left' => -$overdueDays,
                'status_sla' => 'expired',
                'label' => 'Terlambat ' . $overdueDays . ' hari kerja',
                'is_extended' => (bool)$this->perpanjangan_sla,
            ];
        } elseif ($diff <= 3) {
            return [
                'days_left' => $diff,
                'status_sla' => 'warning',
                'label' => 'Sisa ' . $diff . ' hari kerja' . ($this->perpanjangan_sla ? ' (Diperpanjang)' : ''),
                'is_extended' => (bool)$this->perpanjangan_sla,
            ];
        } else {
            return [
                'days_left' => $diff,
                'status_sla' => 'normal',
                'label' => 'Sisa ' . $diff . ' hari kerja' . ($this->perpanjangan_sla ? ' (Diperpanjang)' : ''),
                'is_extended' => (bool)$this->perpanjangan_sla,
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
     * Generate format nomor registrasi unik yang tahan race-condition (UU KIP)
     * Contoh: PPID-202611-0001
     */
    public static function generateNomorRegistrasi(): string
    {
        $prefix = 'PPID-' . date('Ym') . '-';

        return DB::transaction(function () use ($prefix) {
            // Gunakan lockForUpdate untuk mencegah nomor ganda saat submit simultan
            $latest = self::where('nomor_registrasi', 'like', $prefix . '%')
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if ($latest && preg_match('/-(\d+)$/', $latest->nomor_registrasi, $matches)) {
                $number = intval($matches[1]) + 1;
            } else {
                $number = 1;
            }

            $candidate = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);

            // Double check keunikan candidate
            while (self::where('nomor_registrasi', $candidate)->exists()) {
                $number++;
                $candidate = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
            }

            return $candidate;
        });
    }
}
