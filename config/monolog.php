<?php

declare(strict_types=1);

use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;

return [
    'default' => env('MONOLOG_DEFAULT_CHANNEL', 'stderr'),

    'globalLevel' => Logger::toMonologLevel(env('MONOLOG_DEFAULT_LEVEL', 'info')),

    'handlers' => [],

    'processors' => [
        'default' => [
            [
                'class' => PsrLogMessageProcessor::class,
                'options' => [
                    'dateFormat' => 'Y-m-d\TH:i:s.uP',
                ],
            ],
        ],
    ],
];
