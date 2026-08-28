<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Origins autorisés
    'allowed_origins' => [
        'https://app.ms-school.net', // Front officiel en production
    ],

    // Accepte tous les sous-domaines de mh-technologie.com (devv, abiscom25, etc.)
    'allowed_origins_patterns' => [
        '/^https:\/\/[a-z0-9\-]+\.mh-technologie\.com$/',
        '/^http:\/\/localhost(:[0-9]+)?$/', // autorise tous les localhost:port en dev
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Requis si tu utilises login avec cookies ou headers Authorization
    'supports_credentials' => true,

];



//Configuration pour revenir au cors initial

//<?php
//
//return [
//
//    /*
//    |--------------------------------------------------------------------------
//    | Cross-Origin Resource Sharing (CORS) Configuration
//    |--------------------------------------------------------------------------
//    |
//    | Here you may configure your settings for cross-origin resource sharing
//    | or "CORS". This determines what cross-origin operations may execute
//    | in web browsers. You are free to adjust these settings as needed.
//    |
//    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
//    |
//    */
//
//    'paths' => ['api/*'],
//
//    'allowed_methods' => ['*'],
//
//    'allowed_origins' => ['*'],
//
//    'allowed_origins_patterns' => [],
//
//    'allowed_headers' => ['*'],
//
//    'exposed_headers' => [],
//
//    'max_age' => 0,
//
//    'supports_credentials' => false,
//
//];
