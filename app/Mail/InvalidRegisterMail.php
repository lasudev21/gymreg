<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvalidRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($client)
    {
        $payments = Payment::where('client_id', $client->id)->defaultSort('term', 'desc')->take(3)->get();

        $pagos = [];
        foreach ($payments as $key => $value) {
            array_push($pagos, "|$value->amount|$value->term|");
        }

        $this->data = [
            'pagos' => $pagos,
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ingreso fallido',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invalid',
            with: ['data' => $this->data]
        );
    }

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
