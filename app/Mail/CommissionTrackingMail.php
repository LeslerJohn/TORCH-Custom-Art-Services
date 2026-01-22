<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommissionTrackingMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $commissionStatus;
    private string $trackingDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $commissionStatus, string $trackingDetails)
    {
        $this->clientName = $clientName;
        $this->commissionStatus = $commissionStatus;
        $this->trackingDetails = $trackingDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Commission Tracking Update'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.commission-tracking-email',
            with: [
                'clientName' => $this->clientName,
                'commissionStatus' => $this->commissionStatus,
                'trackingDetails' => $this->trackingDetails,
            ],
        );
    }
}
