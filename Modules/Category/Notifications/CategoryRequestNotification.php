<?php

namespace Modules\Category\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Category\Entities\Category;

class CategoryRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    public Category $category;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
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
            'message' => 'New category (' . $this->category->name . ') request received.',
            'url' => route('category.edit', $this->category->id),
        ];
    }
}
