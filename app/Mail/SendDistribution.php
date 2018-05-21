<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDistribution extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $client, $client_email, $text)
    {
        $this->subject      = $subject;
        $this->client       = $client;
        $this->client_email = $client_email;
        $this->text         = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.send_distribution')
                     ->subject($this->subject)
                     ->with([
                        'subject' => $this->subject,
                        'client' => $this->client,
                        'client_email' => $this->client_email,
                        'text' => $this->text
                     ]);
    }
}
