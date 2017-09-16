<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PartnerRegistered extends Mailable
{
    use Queueable, SerializesModels;
    protected $email;
    protected $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.partners.registered')
                    ->subject('Регистрация в системе ЕТКплюс')
                    ->with([
                        'email' => $this->email,
                        'password' => $this->password
                        ]);
    }
}
