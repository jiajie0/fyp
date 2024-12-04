<?php

return [


    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'login_routes' => [
        'developer' => 'developer.login',
        'player' => 'player.login',
        'staff' => 'staff.login',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'player' => [
            'driver' => 'session',
            'provider' => 'players',
        ],
        'developer' => [
            'driver' => 'session',
            'provider' => 'developers',
        ],
        'staff' => [
            'driver' => 'session',
            'provider' => 'staff',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,

        ],
        'players' => [
            'driver' => 'eloquent',
            'model' => App\Models\Player::class,
            'password_field' => 'PlayerPW',
        ],
        'developers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Developer::class,
            'password_field' => 'DeveloperPW',
        ],
        'staff' => [
            'driver' => 'eloquent',
            'model' => App\Models\Staff::class,
            'password_field' => 'StaffPW',
        ],
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
