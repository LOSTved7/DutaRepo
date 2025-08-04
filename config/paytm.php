<?php

return [
    'merchant_id'    => env('PAYTM_MERCHANT_ID', 'Ramanu08337873249877'),
    'merchant_key'   => env('PAYTM_MERCHANT_KEY', 'cvN_094jT%pbazUx'),
    'merchant_website' => env('PAYTM_WEBSITE', 'DEFAULT'),
    'channel_id'     => 'WEB',
    'industry_type'  => 'Retail',
    // 'callback_url'   => env('PAYTM_CALLBACK_URL', url('/paytm/callback')),
    'environment'    => env('PAYTM_ENVIRONMENT', 'production'), // staging or production
];
