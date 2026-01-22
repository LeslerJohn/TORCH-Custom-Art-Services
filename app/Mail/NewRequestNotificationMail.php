<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRequestNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $artistName;
    private string $requestDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(string $artistName, string $requestDetails)
    {
        $this->artistName = $artistName;
        $this->requestDetails = $requestDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'New Service Request Received'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.new-request-notification-email',
            with: [
                'artistName' => $this->artistName,
                'requestDetails' => $this->requestDetails,
            ],
        );
    }
}
