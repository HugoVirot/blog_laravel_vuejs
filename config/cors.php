<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // si * / localhost / localhost:8000 / localhost:8000/api => problème de cookies
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,
// Doc Laravel : You should ensure that your application's CORS configuration is returning the Access-Control-Allow-Credentials 
// header with a value of True. This may be accomplished by setting the supports_credentials option within your application's 
// config/cors.php configuration file to true.
    'supports_credentials' => true,

];
