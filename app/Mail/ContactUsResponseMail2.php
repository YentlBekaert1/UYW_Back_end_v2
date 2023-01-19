<?php

namespace App\Mail;

use ContactUs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsResponseMail2 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_us)
    {
        $this->contact = $contact_us;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('Antwoord op uw vraag')
        ->markdown('mail.response_question', [
            'question' => $this->contact->question,
            'response' => $this->contact->response,
        ]);
    }
}
