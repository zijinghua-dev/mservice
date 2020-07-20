<?php
return [
    'defaults' => [
        'guard' => 'user',
        'passwords' => 'users',
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'user' => [
            'driver' => 'user',
            'provider' => 'users',
        ]
    ],
];