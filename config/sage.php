
<?php

return [

    'url'                   => env('BASE_URL', 'https://pi-test.sagepay.com'),
    'vendorName'            => env('VENDOR_NAME'),
    'authCode'              => env('BASIC_AUTHORIZATION_CODE'),
    'payment_endpoint'      => env('END_POINT_API'),
    'session_key_endpoint'  => env('END_POINT_SESSION', '/api/v1/merchant-session-keys')

];
