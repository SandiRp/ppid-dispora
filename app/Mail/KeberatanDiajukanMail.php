<?php

namespace App\Mail;

use App\Models\Keberatan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KeberatanDiajukanMail extends Mailable
{
    use Queueable, SerializesModels;

    public Keberatan $keberatan;

    public function __construct(Keberatan $keberatan)
    {
        $this->keberatan = $keberatan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Pengajuan Keberatan Informasi Publik [' . $this->keberatan->nomor_keberatan . ']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.keberatan_diajukan',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
