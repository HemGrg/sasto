<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\Order;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

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
        $this->order->loadMissing('customer', 'vendor');

        return $this->subject('Your order has been ' . $this->order->status)
            ->markdown('email.orders.order-status-changed')
            ->with([
                'customerName' => $this->order->customer->name,
                'checkStatusLink' => config('constants.customer_app_url') . '/my-orders/' . $this->order->id
            ]);
    }
}
