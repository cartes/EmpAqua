<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | "auto_tls" negocia STARTTLS cuando el servidor lo ofrece. Desactívalo
    | (MAIL_AUTO_TLS=false) solo si el servidor SMTP tiene un certificado inválido.
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 25),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auto_tls' => env('MAIL_AUTO_TLS', true),
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'empleosaqua@empleosaqua.cl'),
        'name' => env('MAIL_FROM_NAME', 'Empleos Aqua'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Recipient
    |--------------------------------------------------------------------------
    |
    | Destinatario de los mensajes enviados desde el formulario de contacto.
    |
    */

    'contact_to' => env('MAIL_CONTACT_TO', 'empleosaqua@empleosaqua.cl'),

];
