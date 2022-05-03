<?php

namespace App\Mail;

use App\Password;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerResetPassword extends Mailable
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
        return $this->markdown('email.users-password-reset')
        ->with([
            'name' => $this->details->name,
            'token' => config('constants.customer_app_url') . '/reset-password/' . $this->password->token 
        ]);
    }
}
