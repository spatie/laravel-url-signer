<?php

return [

    // A random string used to encrypt the URL signatures.
    'signatureKey' => config('app.key'),

    // The default expiration time of a URL in days.
    'default_expiration_time' => 30,

    // Overwrite these if you want to use different query parameters.
    'parameters' => [
        'expires' => 'expires',
        'signature' => 'signature',
    ],
    
];
