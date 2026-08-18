<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => true,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:update-manifest
    */

    'manifest' => [
        'name' => 'PIS CONNECT',
        'short_name' => 'PIS',
        'background_color' => '#8a0000',
        'display' => 'fullscreen',
        'description' => 'A Progressive Web Application setup for Laravel projects.',
        'theme_color' => '#8a0000',
        'icons' => [
            [
                'src' => 'logo.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
        ],
        'screenshots' => [
            [
                'src' => 'screenshots/desktop.png',
                'sizes' => '1280x720',
                'type' => 'image/png',
                'form_factor' => 'wide',
            ],
            [
                'src' => 'screenshots/mobile.png',
                'sizes' => '350x712',
                'type' => 'image/png',
                // form_factor tidak diisi / bisa juga 'narrow'
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Livewire Integration
    |--------------------------------------------------------------------------
    | Set to true if you're using Livewire in your application to enable
    | Livewire-specific PWA optimizations or features.
    */

    'livewire-app' => true,
];
