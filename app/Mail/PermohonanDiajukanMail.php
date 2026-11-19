<?php

namespace App\Mail;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PermohonanDiajukanMail extends Mailable
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
            subject: 'Bukti Pengajuan Permohonan Informasi Publik [' . $this->permohonan->nomor_registrasi . ']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.permohonan_diajukan',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
