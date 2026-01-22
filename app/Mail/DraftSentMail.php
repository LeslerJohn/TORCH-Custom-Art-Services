<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DraftSentMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $draftDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $draftDetails)
    {
        $this->clientName = $clientName;
        $this->draftDetails = $draftDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Draft Sent for Your Review'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.draft-sent-email',
            with: [
                'clientName' => $this->clientName,
                'draftDetails' => $this->draftDetails,
            ],
        );
    }
}
