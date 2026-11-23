<?php

use App\Models\Customer;
use App\Models\Kasir;

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],


        'kasir' => [
            'driver' => 'session',
            'provider' => 'kasirs',
        ],
    ],

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => Customer::class,
        ],

       
        'kasirs' => [
            'driver' => 'eloquent',
            'model' => Kasir::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'customers',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];