<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberExpiringSoonMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Membership $membership
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⏳ ¡Solo quedan 7 días de tu plan en GYMADM!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.expiring-soon',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
