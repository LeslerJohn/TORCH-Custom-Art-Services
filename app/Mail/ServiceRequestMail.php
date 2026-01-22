<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $serviceDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $serviceDetails)
    {
        $this->clientName = $clientName;
        $this->serviceDetails = $serviceDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Service Artwork Request Confirmation'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.service-request-email',
            with: [
                'clientName' => $this->clientName,
                'serviceDetails' => $this->serviceDetails,
            ],
        );
    }
}
