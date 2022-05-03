<?php

namespace Modules\Subcategory\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Subcategory\Entities\Subcategory;

class SubcategoryRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Subcategory $subcategory;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
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
            'message' => 'New Sub-category (' . $this->subcategory->name . ') request received.',
            'url' => route('subcategory.edit', $this->subcategory->id),
        ];
    }
}
