<?php

declare(strict_types=1);

return [
    'default' => env('CACHE_STORAGE', 'rr-local'),

    'storages' => [
        'redis' => [
            'type' => 'redis',
            'options' => [
                'connection' => 'cache',
                'serializer' => 'json',
            ],
        ],

        'rr-local' => [
            'type' => 'roadrunner',
            'driver' => 'local',
        ],
    ],
];
