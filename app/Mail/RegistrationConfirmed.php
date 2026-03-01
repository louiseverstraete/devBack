<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class RegistrationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Registration $registration) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation d\'inscription',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmed', 
            with: [
            'cancelUrl' => URL::signedRoute('registrations.cancel', [
                'registration' => $this->registration->registration_id,
            ]),
        ]
        );
    }
}