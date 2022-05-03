<?php

namespace Modules\Front\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendorStatusChangeMessageNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['smsapi'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSmsApi($notifiable)
    {
         switch ($this->user->vendor_type) {
            case "approved":
                $this->user->vendor_type = 'approved';
                break;
            case "suspended":
                $this->user->vendor_type = 'suspended. Please check your email for further details.';
                break;
                default:
                $this->user->vendor_type = 'new';
            break;
        }
        return [
            'message' => 'Your vendor has been #' . $this->user->vendor_type . '. ',
        ];
        
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
