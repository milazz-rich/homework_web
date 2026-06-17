<?php

return [
    'access_key' => env('MAILBOXLAYER_ACCESS_KEY', ''),
    'endpoint' => env('MAILBOXLAYER_ENDPOINT', 'https://apilayer.net/api/check'),
    'timeout' => env('MAILBOXLAYER_TIMEOUT', 20),
];
