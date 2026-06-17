<?php

return [
    'secret_key' => env('STRIPE_SECRET_KEY', ''),
    'publishable_key' => env('STRIPE_PUBLISHABLE_KEY', ''),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),
    'currency' => env('STRIPE_CURRENCY', 'eur'),
    'base_url' => env('STRIPE_BASE_URL', 'https://api.stripe.com/v1'),
    'timeout' => env('STRIPE_TIMEOUT', 30),
];