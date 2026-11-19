<?php

namespace App\Mail;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusPermohonanUpdatedMail extends Mailable
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
            subject: 'Pembaruan Status Permohonan Informasi [' . $this->permohonan->nomor_registrasi . ']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.status_permohonan_updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
