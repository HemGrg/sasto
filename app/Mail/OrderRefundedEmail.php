<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\Order;

class OrderRefundedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // this email is for customer
        return $this->markdown('email.orders.order-refunded')
        ->subject('Order Refunded')
        ->with([
            'customerName' => $this->order->customer->name,
            // 'checkStatusLink' => config('constants.customer_app_url') . '/my-orders/' . $this->order->id
        ]);
    }
}
