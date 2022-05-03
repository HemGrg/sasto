<?php

namespace Modules\Payment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Payment\Entities\Transaction;
use Modules\User\Entities\Vendor;

class PaymentReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    Public Transaction $transaction;
    Public Vendor $vendor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, Vendor $vendor)
    {
        $this->transaction = $transaction;
        $this->vendor = $vendor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have received a payment of ' . price_unit() . $this->transaction->amount . ' from Sasto Wholesale.',
            'url' => route('transactions.index', $this->vendor->user->id),
        ];
    }
}
