<?php

namespace Modules\Payment\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Payment\Service\TransactionService;
use Modules\User\Entities\Vendor;

class PaymentRequestMail extends Mailable
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
    public function build(TransactionService $transactionService)
    {
        $remainingPayment = $transactionService->getCurrentBalance($this->vendor->id);

        return $this->markdown('payment::email.payment-request')
            ->subject('Payment Request')
            ->with([
                'vendorName' => $this->vendor->shop_name,
                'remainingPayment' => $remainingPayment,
                'actionLink' => url('/transactions/'. $this->vendor->user->id)
            ]);
    }
}
