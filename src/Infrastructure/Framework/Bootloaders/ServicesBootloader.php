<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use App\Domain\Services\ExternalServiceInterface;
use App\Infrastructure\Providers\ServiceConfigurator;
use App\Infrastructure\Providers\ServiceConfiguratorInterface;
use App\Infrastructure\Services\Auth\ExternalService;
use Predis\Client;
use Predis\ClientInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Config\ConfiguratorInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ServicesBootloader extends Bootloader
{
    public function defineBindings(): array
    {
        return [
            ExternalServiceInterface::class => ExternalService::class,
            ServiceConfiguratorInterface::class => ServiceConfigurator::class,
            HttpClientInterface::class => static fn(): HttpClientInterface => HttpClient::create(),
        ];
    }

    public function defineSingletons(): array
    {
        return [
            ClientInterface::class => static function (ConfiguratorInterface $config): Client {
                $redisConfig = $config->getConfig('redis');
                $connectionConfig = $redisConfig['connections']['default'];

                return new Client([
                    'scheme' => 'tcp',
                    'host' => $connectionConfig['host'],
                    'port' => $connectionConfig['port'],
                    'database' => $connectionConfig['database'] ?? 0,
                    'password' => $connectionConfig['password'] ?? null,
                ], $connectionConfig['options'] ?? []);
            },

            Client::class => static function (ClientInterface $client): Client {
                return $client;
            },
        ];
    }
}
