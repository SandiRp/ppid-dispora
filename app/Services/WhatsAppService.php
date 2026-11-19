<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim pesan teks WhatsApp ke nomor tujuan
     * Format nomor otomatis dinormalisasi ke format internasional (misal 0812 -> 62812)
     */
    public static function send(string $nomorHp, string $pesan): bool
    {
        $token = config('services.whatsapp.token');
        $endpoint = config('services.whatsapp.endpoint', 'https://api.fonnte.com/send');

        if (empty($token)) {
            Log::info("WhatsApp Gateway tidak aktif (FONNTE_TOKEN belum diatur). Pesan untuk {$nomorHp}: {$pesan}");
            return false;
        }

        // Normalisasi nomor telepon
        $target = preg_replace('/[^0-9]/', '', $nomorHp);
        if (str_starts_with($target, '08')) {
            $target = '628' . substr($target, 2);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(10)->post($endpoint, [
                'target' => $target,
                'message' => $pesan,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                Log::info("Notifikasi WhatsApp berhasil dikirim ke {$target}");
                return true;
            } else {
                Log::warning("Gagal mengirim WhatsApp ke {$target}: " . $response->body());
                return false;
            }
        } catch (\Throwable $e) {
            Log::error("Error koneksi WhatsApp Gateway: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Format notifikasi permohonan baru untuk WhatsApp
     */
    public static function notifyPermohonanBaru($permohonan): void
    {
        $pesan = "Halo {$permohonan->nama_lengkap},\n\n"
               . "Permohonan Informasi Publik Anda di *PPID Dispora Jawa Timur* telah berhasil diajukan dengan:\n"
               . "📋 *Nomor Registrasi:* {$permohonan->nomor_registrasi}\n"
               . "📅 *Tanggal:* " . now()->format('d/m/Y') . "\n\n"
               . "Simpan Nomor Registrasi Anda bersama NIK untuk melacak perkembangan status pelayanan secara online di website resmi PPID Dispora Jatim.\n\n"
               . "Terima kasih.\n_PPID Dispora Jawa Timur_";

        self::send($permohonan->nomor_telepon, $pesan);
    }

    /**
     * Format notifikasi perubahan status untuk WhatsApp
     */
    public static function notifyStatusUpdated($permohonan): void
    {
        $statusStr = strtoupper($permohonan->status);
        $pesan = "Halo {$permohonan->nama_lengkap},\n\n"
               . "Status permohonan informasi Anda (*{$permohonan->nomor_registrasi}*) telah diperbarui menjadi:\n"
               . "📌 *STATUS: {$statusStr}*\n";

        if ($permohonan->catatan_admin) {
            $pesan .= "💬 *Catatan Petugas:* {$permohonan->catatan_admin}\n";
        }

        if ($permohonan->status === 'selesai') {
            $pesan .= "\nBerkas informasi telah tersedia dan dapat diunduh di portal lacak status. Mohon kesediaannya mengisi Survei Kepuasan (IKM).\n";
        } elseif ($permohonan->status === 'ditolak') {
            $pesan .= "\nAlasan Penolakan: {$permohonan->alasan_penolakan}\nAnda dapat mengajukan keberatan kepada Atasan PPID dalam 30 hari kerja.\n";
        }

        $pesan .= "\nKunjungi portal resmi: " . url('/lacak-permohonan') . "\n_PPID Dispora Jawa Timur_";

        self::send($permohonan->nomor_telepon, $pesan);
    }
}
