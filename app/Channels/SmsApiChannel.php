<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SmsApiChannel
{
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('smsapi');

        if (!$to) {
            $to = $notifiable->routeNotificationFor(SmsApiChannel::class);
        }

        if (!$to) {
            return;
        }

        $data = method_exists($notification, 'toSmsApi')
            ? $notification->toSmsApi($notifiable)
            : $notification->toArray();

        if (empty($data)) {
            return;
        }

        if (config('services.sms_api.driver') == 'log') {
            logger(json_encode([
                'to' => $to,
                'data' => $data
            ]));
            logger('SMS to mobile: ' . $to .  ' with message: ' . $data['message']);
        }

        if (config('services.sms_api.driver') == 'api') {
            $response = Http::get('http://api.sparrowsms.com/v2/sms/', [
                'token' => settings('sms_api_token'),
                'from' => settings('sms_identity'),
                'to' => $to,
                'text' => $data['message'],
            ]);

            if (!$response->successful()) {
                throw new \Exception('SMS API error: ' . $response->body());
            }

        }

        return true;
    }
}
