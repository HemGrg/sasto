<?php

return  [
    'esewa' => [
        'merchant_id' => env('ESEWA_MERCHANT_ID'),
        'transaction_url' => env('ESEWA_TRANSACTION_URL', 'https://uat.esewa.com.np/epay/main'),
        'transaction_verification_url' => env('ESEWA_TRANSACTION_VERIFICATION_URL', 'https://esewa.com.np/epay/transrec'),
    ],
];
