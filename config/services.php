<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Telegram credentials
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'chat_id' => env('TELEGRAM_CHAT_ID'),
    ],

    // Stripe
    'stripe' => [
        'public' => env('STRIPE_PUBLIC'),
        'secret' => env('STRIPE_SECRET'),
    ],

    // Google Socialite Oauth credentials
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),

        'redirect' => env('GOOGLE_REDIRECT_URI'),  // on local host
        'redirect_for_render' => env('GOOGLE_REDIRECT_URI_FOR_RENDER'),  // on production Render.com

        'sheet_id' => env('GOOGLE_SHEET_ID'),  // used in GoogleSpreadsheetController
    ],

    // Mapbox api key
    'mapbox' => [
        'token' => env('MAPBOX_API_KEY'),
    ],

    // Horizon allowed emails
    'horizon' => [
        'allowed_emails' => env('HORIZON_ALLOWED_EMAILS'),
    ],

];
