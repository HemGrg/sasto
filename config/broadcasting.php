<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        // 'pusher' => [
        //     'driver' => 'pusher',
        //     'key' => env('PUSHER_APP_KEY', 'cbe0b7b8904e2ede8292'),
        //     'secret' => env('PUSHER_APP_SECRET', 'e934d010ddd74158d0ba'),
        //     'app_id' => env('PUSHER_APP_ID', '1283512'),
        //     'options' => [
        //         'cluster' => env('PUSHER_APP_CLUSTER', 'ap2'),
        //         'useTLS' => true,
        //         'host' => env('LARAVEL_WEBSOCKETS_HOST', '127.0.0.1'),
        //         'port' => env('LARAVEL_WEBSOCKETS_PORT', 6001),
        //         'scheme' => env('PUSHER_APP_SCHEME', 'http'),
        //         'curl_options' => [
        //             CURLOPT_SSL_VERIFYHOST => 0,
        //             CURLOPT_SSL_VERIFYPEER => 0,
        //         ],
        //     ],
        // ],

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
