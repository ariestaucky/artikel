<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    /* Social Media */
    'facebook' => [
        'client_id'     => '790223781375961',
        'client_secret' => '82878e867bc77a489a6656f3f1010d98',
        'redirect'      => 'https://site.test/auth/facebook/callback',
    ],
    'twitter' => [
        'client_id'     => 'azrjaJvcbpBhV26RqRHK86SH3',
        'client_secret' => 'NyvRN1bo2i8MX9eDwwzu7EbJGvKIrhWS2mhuMmgEJ6Q5lWQSpC',
        'redirect'      => 'https://site.test/auth/twitter/callback',
    ],

];
