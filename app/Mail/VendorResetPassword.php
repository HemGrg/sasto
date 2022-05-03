<?php

namespace App\Mail;

use App\Password;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\Vendor;

class VendorResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Password $password, Vendor $vendor)
    {
        $this->password = $password;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.vendors-password-reset')
            ->subject('Reset Password')
            ->with([
                'name' => $this->vendor->user->name,
                'link' => url('password-resetform/' . $this->vendor->user->token),
            ]);
    }
}
