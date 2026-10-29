<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Implementa ShouldQueue — dice a Laravel che questa email va messa in coda, non inviata subito
class EmailChangeVerification extends Mailable implements ShouldQueue
{
    // Il costruttore riceve $verifyUrl come proprietà pubblica — viene automaticamente serializzata in coda con SerializesModels
    use Queueable, SerializesModels;
    public function __construct(public string $verifyUrl) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Conferma il cambio email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-change-verification',
            with: ['verifyUrl' => $this->verifyUrl],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
