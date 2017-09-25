<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OperatorCreated extends Mailable
{
    use Queueable, SerializesModels;
    protected $email;
    protected $name;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$password,$name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.partners.operator_created')
                    ->subject('Регистрация учетной записи оператора')
                    ->with([
                        'email' => $this->email,
                        'password' => $this->password,
                        'name' => $this->name
                        ]);
    }
}
