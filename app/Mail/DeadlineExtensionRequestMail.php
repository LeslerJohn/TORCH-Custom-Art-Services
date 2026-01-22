<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineExtensionRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $artistName;
    private string $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $artistName, string $reason)
    {
        $this->clientName = $clientName;
        $this->artistName = $artistName;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Deadline Extension Request'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.deadline-extension-request-email',
            with: [
                'clientName' => $this->clientName,
                'artistName' => $this->artistName,
                'reason' => $this->reason,
            ],
        );
    }
}
