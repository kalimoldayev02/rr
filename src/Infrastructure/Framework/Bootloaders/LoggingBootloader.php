<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\SocketHandler;
use Monolog\Handler\StreamHandler;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Monolog\Bootloader\MonologBootloader;

final class LoggingBootloader extends Bootloader
{
    public function init(MonologBootloader $monolog, EnvironmentInterface $env): void
    {
        // socket
        if (!is_null($env->get('MONOLOG_SOCKET_URL'))) {
            $monolog->addHandler(
                'socket',
                handler: new SocketHandler(
                    connectionString: $env->get('MONOLOG_SOCKET_URL'),
                )->setFormatter(new JsonFormatter(JsonFormatter::BATCH_MODE_NEWLINES)),
            );
        }

        // stderr
        $monolog->addHandler(
            'stderr',
            handler: new StreamHandler(
                stream: 'php://stderr',
            )->setFormatter(new JsonFormatter(JsonFormatter::BATCH_MODE_NEWLINES)),
        );
    }
}
