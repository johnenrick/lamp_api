<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Origin', 'Authorization', 'authorization', 'Header', 'header', 'X-Requested-With', 'Content-Type', 'Accept'],
    'allowedMethods' => ['GET', 'POST', 'post', 'PUT', 'DELETE', 'OPTIONS', 'PATCH'],
    'exposedHeaders' => ['authorization', 'Authorization', 'Header', 'header'],
    'maxAge' => 0,

];
