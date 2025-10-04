<?php

declare(strict_types=1);

use Spiral\Queue\Driver\SyncDriver;
use Spiral\RoadRunner\Jobs\Queue\MemoryCreateInfo;

return [
    'default' => env('QUEUE_CONNECTION', 'in-memory'),

    'aliases' => [
        // 'mail-queue' => 'in-memory',
        // 'rating-queue' => 'sync',
    ],

    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
        'in-memory' => [
            'driver' => 'roadrunner',
            'pipeline' => 'memory',
        ],
    ],

    'pipelines' => [
        'memory' => [
            'connector' => new MemoryCreateInfo('local'),
            'consume' => true,
        ],
        // 'amqp' => [
        //     'connector' => new AMQPCreateInfo('bus', ...),
        //     // Don't consume jobs for this pipeline on start
        //     // You can run consumer for this pipeline via console command
        //     // php app.php queue:resume local
        //     'consume' => false
        // ],
        //
        // 'beanstalk' => [
        //     'connector' => new BeanstalkCreateInfo('bus', ...),
        // ],
        //
        // 'sqs' => [
        //     'connector' => new SQSCreateInfo('amazon', ...),
        // ],
    ],

    'defaultSerializer' => 'json',

    'registry' => [
        'handlers' => [
            // 'ping' => \App\Endpoint\Job\Ping::class
        ],

        'serializers' => [
            // 'ping' => 'json',
            // \App\Endpoint\Job\Ping::class => 'json',
        ],
    ],

    'interceptors' => [
        // 'push' => [],
        // 'consume' => [],
    ],

    'driverAliases' => [
        'sync' => SyncDriver::class,
    ],
];
