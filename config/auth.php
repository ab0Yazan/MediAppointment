<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],


    'guards' => [
        'doctor' => [
            'driver' => 'sanctum',
            'provider' => 'doctors',
        ],
        'client' => [
            'driver' => 'sanctum',
            'provider' => 'clients',
        ]
    ],


    'providers' => [
        'doctors' => [
            'driver' => 'eloquent',
            'model' => Modules\Auth\app\Models\Doctor::class,
        ],
        'clients' => [
            'driver' => 'eloquent',
            'model' => Modules\Auth\Models\Client::class,
        ]
    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
