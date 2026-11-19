<?php

namespace App\Mail;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPermohonanBaruAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public Permohonan $permohonan;

    public function __construct(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ [Permohonan Masuk] Nomor Registrasi: ' . $this->permohonan->nomor_registrasi . ' - ' . $this->permohonan->nama_lengkap,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_permohonan_baru',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
