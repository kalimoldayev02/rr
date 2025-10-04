<?php

declare(strict_types=1);

return [
    'default' => env('REDIS_CONNECTION', 'default'),
    'connections' => [
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DATABASE', 0),
        ],
    ],
];