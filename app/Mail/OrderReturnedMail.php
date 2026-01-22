<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReturnedMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $orderDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $orderDetails)
    {
        $this->clientName = $clientName;
        $this->orderDetails = $orderDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Order Return Confirmation'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.order-returned-email',
            with: [
                'clientName' => $this->clientName,
                'orderDetails' => $this->orderDetails,
            ],
        );
    }
}
