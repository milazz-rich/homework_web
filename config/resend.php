<?php

return [
    'api_key' => env('RESEND_API_KEY', ''),
    'from' => env('RESEND_FROM', 'noreply@milaz.it'),
    'endpoint' => env('RESEND_ENDPOINT', 'https://api.resend.com/emails'),
    'timeout' => env('RESEND_TIMEOUT', 20),
];