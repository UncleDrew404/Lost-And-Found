<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    | The origins that are allowed to make requests to your API.
    | Your Vue 3 dev server runs on port 5173.
    */
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5173')],

    /*
    | HTTP methods the frontend is allowed to use
    */
    'allowed_methods' => ['*'],

    /*
    | Headers the frontend is allowed to send
    */
    'allowed_headers' => ['*'],

    /*
    | Headers exposed to the frontend JavaScript
    */
    'exposed_headers' => [],

    /*
    | Max age (seconds) the browser caches the CORS preflight response
    */
    'max_age' => 0,

    /*
    | Whether to include cookies/auth headers in cross-origin requests
    */
    'supports_credentials' => true,

    /*
    | Which URL paths CORS applies to (all API routes)
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

];
