<?php

declare(strict_types=1);

return [
    'enabled' => true,

    'manifest' => [
        'name' => env('APP_NAME', 'Filakit'),
        'short_name' => env('APP_NAME', 'Filakit'),
        'description' => 'A Progressive Web App built with Laravel.',
        'start_url' => '/?source=pwa',
        'scope' => '/',
        'display' => 'standalone',
        'orientation' => 'any',
        'theme_color' => '#ffffff',
        'background_color' => '#ffffff',
        'lang' => 'en',
        'dir' => 'ltr',
        'categories' => ['productivity'],
        // TODO: icon-512x512.png and icon-512x512-maskable.png in resources/favicon
        // are upscaled placeholders generated from android-icon-192x192.png.
        // Replace with proper high-resolution 512x512 source icons.
        'icons' => [
            '36' => '0.75',
            '48' => '1.0',
            '72' => '1.5',
            '96' => '2.0',
            '144' => '3.0',
            '192' => '4.0',
        ],
    ],

    'favicon' => 'resources/favicon/favicon.ico',

    'tile_color' => '#ffffff',

    'apple_status_bar_style' => 'black',
];
