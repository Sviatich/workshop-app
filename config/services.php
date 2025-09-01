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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'metrica' => [
        'id'          => env('METRICA_ID'),
        'webvisor'    => filter_var(env('METRICA_WEBVISOR', true), FILTER_VALIDATE_BOOL),
        'clickmap'    => filter_var(env('METRICA_CLICKMAP', true), FILTER_VALIDATE_BOOL),
        'track_links' => filter_var(env('METRICA_TRACK_LINKS', true), FILTER_VALIDATE_BOOL),
    ],
    'verification' => [
        'google' => env('VERIFY_GOOGLE'),
        'yandex' => env('VERIFY_YANDEX'),
    ],

    'yandex' => [
        // API ключ для Яндекс.Карт JS v3. Задайте в .env: YANDEX_MAPS_API_KEY=...
        'maps_key' => env('YANDEX_MAPS_API_KEY'),
    ],

    // Dadata suggestions
    'dadata' => [
        'token' => env('DADATA_TOKEN'),
    ],

    // CDEK API settings
    'sdek' => [
        'base_url' => env('CDEK_BASE_URL', 'https://api.cdek.ru/v2'),
        'client_id' => env('CDEK_CLIENT_ID'),
        'client_secret' => env('CDEK_CLIENT_SECRET'),
        'sender_code' => env('CDEK_SENDER_CODE', 171),
        // Allowed tariffs (CSV). 138: Door->PVZ, 139: Door->Door
        'allowed_tariffs_office' => env('CDEK_ALLOWED_TARIFFS_OFFICE', '138'),
        'allowed_tariffs_door' => env('CDEK_ALLOWED_TARIFFS_DOOR', '139'),
    ],

];
