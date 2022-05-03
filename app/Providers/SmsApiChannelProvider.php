<?php

namespace App\Providers;

use App\Channels\SmsApiChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SmsApiChannelProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Notification::extend('smsapi', function ($app) {
            return new SmsApiChannel();
        });
    }
}
