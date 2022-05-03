<?php

namespace Modules\ProductCategory\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\ProductCategory\Entities\ProductCategory;

class ProductCategoryRequestNotification extends Notification
{
    use Queueable;

    public ProductCategory $productCategory;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductCategory $productCategory)
    {
        $this->productCategory = $productCategory;
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
            'message' => 'New Product Category (' . $this->productCategory->name . ') request received.',
            'url' => route('product-category.edit', $this->productCategory->id),
        ];
    }
}
