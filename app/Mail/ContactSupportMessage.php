<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactSupportMessage extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        // Sets the reply-to address so you can easily reply to the user from your inbox
        return new Envelope(
            replyTo: [
                new Address($this->data['email'], $this->data['name']),
            ],
            subject: 'Grit Support Request: '.$this->data['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-support',
        );
    }
}
