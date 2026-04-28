<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Membership $membership
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 ¡Tu membresía en GYMADM ha vencido!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.expired', // Ruta de la vista
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
