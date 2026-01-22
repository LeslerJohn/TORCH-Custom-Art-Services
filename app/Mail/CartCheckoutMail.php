<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CartCheckoutMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $clientName;
    private string $artworkDetails;
    private float $totalAmount;

    /**
     * Create a new message instance.
     */
    public function __construct(string $clientName, string $artworkDetails, float $totalAmount)
    {
        $this->clientName = $clientName;
        $this->artworkDetails = $artworkDetails;
        $this->totalAmount = $totalAmount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('torch@gmail.com', 'Torch'),
            subject: 'Your Artwork Purchase Confirmation'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.cart-checkout-email',
            with: [
                'clientName' => $this->clientName,
                'artworkDetails' => $this->artworkDetails,
                'totalAmount' => $this->totalAmount,
            ],
        );
    }
}
