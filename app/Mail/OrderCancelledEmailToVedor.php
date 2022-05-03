<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\Order;

class OrderCancelledEmailToVedor extends Mailable implements ShouldQueue
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
        return $this->markdown('email.orders.order-cancelled-to-vendor')
        ->subject('Order Cancelled')
        ->with([
            'checkStatusLink' => route('orders.show', $this->order->id)
        ]);
    }
}
