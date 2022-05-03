<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (request()->hasHeader('authorization')) {
            // logger('Using auth:api middleware for channel authorization');
            Broadcast::routes(['middleware' => ['auth:api']]);
        } else {
            // logger('Using web middleware for channel authorization');
            // Broadcast::routes(['middleware' => ['web', 'auth']]);
            Broadcast::routes();
        }

        // Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
