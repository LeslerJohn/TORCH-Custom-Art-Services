<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineExtensionResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $artistName;
    private string $clientName;
    private string $response;

    /**
     * Create a new message instance.
     */
    public function __construct(string $artistName, string $clientName, string $response)
    {
        $this->artistName = $artistName;
        $this->clientName = $clientName;
        $this->response = $response;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Deadline Extension Response'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.deadline-extension-response-email',
            with: [
                'artistName' => $this->artistName,
                'clientName' => $this->clientName,
                'response' => $this->response,
            ],
        );
    }
}
