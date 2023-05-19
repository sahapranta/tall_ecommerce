<?php

return [
    'stripe_key' => env('STRIPE_KEY'),
    'stripe_secret' => env('STRIPE_SECRET'),
    'stripe_webhook' => env('STRIPE_WEBHOOK_SECRET'),
    'recaptcha_key' => env('GOOGLE_RECAPTCHA_KEY'),
    'recaptcha_secret' => env('GOOGLE_RECAPTCHA_SECRET'),
    'empty' => env('EMPTY'),
];
