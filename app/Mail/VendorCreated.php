<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\Vendor;

class VendorCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->vendor->loadMissing('user');

        return $this->markdown('email.account-verification-mail')
            ->subject('Account Verification')
            ->with([
                'name' => $this->vendor->user->name,
                'link' => url('account-activate/' . $this->vendor->user->activation_link),
                'otp' => $this->vendor->user->otp,
            ]);
    }
}
