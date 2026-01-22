<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderTrackingMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $orderStatus;
    private string $trackingDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $orderStatus, string $trackingDetails)
    {
        $this->clientName = $clientName;
        $this->orderStatus = $orderStatus;
        $this->trackingDetails = $trackingDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Order Tracking Update'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.order-tracking-email',
            with: [
                'clientName' => $this->clientName,
                'orderStatus' => $this->orderStatus,
                'trackingDetails' => $this->trackingDetails,
            ],
        );
    }
}
