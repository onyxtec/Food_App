<?php

namespace App\Mail;

use App\Models\TimeSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTimingsNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $time_setting;

    /**
     * Create a new message instance.
     */
    public function __construct(TimeSetting $time_setting)
    {
        $this->time_setting = $time_setting;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Order Timings Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-timings-notification',
        );
    }
}
