<?php

namespace Modules\Quotation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Quotation\Entities\Quotation;

class NewQuotationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Quotation $quotation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Quotation $quotation)
    {
        $this->quotation = $quotation;
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
            'message' => 'A new quotation has been received.',
            'url' => route('quotations.show', $this->quotation->id),
        ];
    }

}
