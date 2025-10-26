<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use Spiral\Config\ConfiguratorInterface;

final readonly class ServiceConfigurator implements ServiceConfiguratorInterface
{
    private const string CONFIG = 'services';

    public function __construct(
        private ConfiguratorInterface $config,
    ) {}

    public function get(string $service, string $key): mixed
    {
        return $this->config->getConfig(self::CONFIG)[$service][$key] ??
            throw new \RuntimeException("Invalid configuration for $service [$key]");
    }
}
