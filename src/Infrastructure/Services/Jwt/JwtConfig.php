<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Jwt;

use Spiral\Config\ConfiguratorInterface;

final readonly class JwtConfig
{
    private const string CONFIG = 'jwt';

    public function __construct(
        private ConfiguratorInterface $config,
    ) {}

    public function get(string $key): mixed
    {
        return $this->config->getConfig(self::CONFIG)[$key] ??
            throw new \RuntimeException("Invalid configuration for jwt [$key]");
    }
}
