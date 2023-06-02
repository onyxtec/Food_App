<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $orders;
    /**
     * Create a new message instance.
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weekly Order Report',
        );
    }

    // /**
    //  * Get the message content definition.
    //  */
    public function content(): Content
    {
        return new Content(
            view: 'emails.weekly-order-report',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->subject('Hello')->view('emails.weekly-order-report');

    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
