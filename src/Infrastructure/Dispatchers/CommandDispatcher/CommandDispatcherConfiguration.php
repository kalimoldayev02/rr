<?php

declare(strict_types=1);

namespace App\Infrastructure\Dispatchers\CommandDispatcher;

use Spiral\Config\ConfiguratorInterface;

final readonly class CommandDispatcherConfiguration
{
    private const string CONFIG = 'commands';

    public function __construct(
        private ConfiguratorInterface $config,
    ) {}

    public function get(string $commandClass, string $key, mixed $default = null): mixed
    {
        return $this->config->getConfig(self::CONFIG)[$commandClass][$key] ?? $default;
    }
}
