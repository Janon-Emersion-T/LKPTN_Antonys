<?php

return [
    'company' => [
        'name' => env('GLOBALS_COMPANY_NAME', 'TechHub'),
        'tagline' => env('GLOBALS_COMPANY_TAGLINE', 'Your technology partner'),
        'url' => env('GLOBALS.CONTACT.URL', ''),
    ],

    'contact' => [
        'email' => env('GLOBALS.CONTACT.EMAIL', ''),
        'phone_number' => env('GLOBALS.CONTACT.PHONE_NUMBER', ''),
        'whatsapp_phone_number' => env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER', ''),
        'address' => env('GLOBALS.CONTACT.ADDRESS', ''),
    ],

    'socials' => [
        'facebook' => env('GLOBALS.SOCIALS.FACEBOOK', ''),
        'x' => env('GLOBALS.SOCIALS.X', ''),
        'linkedin' => env('GLOBALS.SOCIALS.LINKEDIN', ''),
        'instagram' => env('GLOBALS.SOCIALS.INSTAGRAM', ''),
        'tiktok' => env('GLOBALS.SOCIALS.TIKTOK', ''),
    ],

    'other' => [
        'company_opening_hours' => env('GLOBALS.COMPANY_OPENING_HOURS', ''),
        'map_iframe' => env('GLOBALS.MAP_IFRAME', ''),
    ],
];