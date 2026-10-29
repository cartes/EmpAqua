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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'smtp' => [
        'host' => env('SMTP_HOST', 'mail.editec.cl'),
        'port' => (int) env('SMTP_PORT', 25),
        'username' => env('SMTP_USERNAME'),
        'password' => env('SMTP_PASSWORD'),
        'encryption' => env('SMTP_ENCRYPTION'),
        'from' => env('SMTP_FROM', 'empleosaqua@empleosaqua.cl'),
        'contact_to' => env('SMTP_CONTACT_TO', 'empleosaqua@empleosaqua.cl'),
    ],

    'intersticial'  => env('INTERSTICIAL', true),

];
