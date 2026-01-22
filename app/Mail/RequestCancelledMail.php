<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $requestDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $requestDetails)
    {
        $this->clientName = $clientName;
        $this->requestDetails = $requestDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Service Request Cancellation'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.request-cancelled-email',
            with: [
                'clientName' => $this->clientName,
                'requestDetails' => $this->requestDetails,
            ],
        );
    }
}
