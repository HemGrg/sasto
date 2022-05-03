<?php

namespace App\Mail;

use App\Password;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $password;
    public $details;
    
    public function __construct(Password $password, $details)
    {
        $this->password = $password;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.password-reset')
        ->with([
            'name' => $this->details->name,
            'token' => url('password-resetform/' . $this->password->token)
        ]);
    }
}
