<?php



return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Vimeo Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'environment' => 'production',
            'merchant_id' => 'your-merchant-id',
            'public_key'  => 'your-public-key',
            'private_key' => 'your-private-key',
        ],

        'sandbox' => [
            'environment' => 'sandbox',
            'merchant_id' => 'your-sandbox-merchant-id',
            'public_key'  => 'your-sandbox-public-key',
            'private_key' => 'your-sandbox-private-key',
        ],

    ],

];
