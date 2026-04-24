<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminDailyExpirationsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $vencidosHoy,
        public $sinAccesoRecientes
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 Reporte Diario de Membresías - GYMADM',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-report',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
