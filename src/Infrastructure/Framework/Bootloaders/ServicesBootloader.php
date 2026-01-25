<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use App\Application\Dispatchers\CommandDispatcher\CommandDispatcherInterface;
use App\Domain\Services\Activity\SyncActivityDetail\GetActivityDetailExternalServiceInterface;
use App\Domain\Services\Athlete\ExchangeAthleteCode\ExchangeAthleteCodeInterface;
use App\Domain\Services\Athlete\GetAthleteClubs\GetAthleteClubsServiceInterface;
use App\Domain\Services\Athlete\GetRegisterAthleteUrl\GetRegisterAthleteUrlServiceInterface;
use App\Domain\Services\Jwt\JwtServiceInterface;
use App\Domain\Services\OAuthToken\RefreshOAuthToken\RefreshOAuthTokenServiceInterface;
use App\Infrastructure\Dispatchers\CommandDispatcher\CommandDispatcher;
use App\Infrastructure\Providers\ServiceConfigurator;
use App\Infrastructure\Providers\ServiceConfiguratorInterface;
use App\Infrastructure\Services\Activity\GetActivityDetail\GetActivityDetailService;
use App\Infrastructure\Services\Activity\SyncActivities\GetActivitiesService;
use App\Infrastructure\Services\Athlete\ExchangeAthleteCode\ExchangeAthleteCodeService;
use App\Infrastructure\Services\Athlete\GetAthleteClubs\GetAthleteClubsService;
use App\Infrastructure\Services\Athlete\GetRegisterAthleteUrl\GetRegisterAthleteUrlService;
use App\Infrastructure\Services\Jwt\JwtService;
use App\Infrastructure\Services\OAuthToken\RefreshOAuthToken\RefreshOAuthTokenService;
use Predis\Client;
use Predis\ClientInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;
use App\Domain\Services\Activity\SyncActivities\GetActivitiesExternalServiceInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ServicesBootloader extends Bootloader
{
    public function defineSingletons(): array
    {
        return [
            ServiceConfiguratorInterface::class => ServiceConfigurator::class,
            HttpClientInterface::class => static fn(): HttpClientInterface => HttpClient::create(),
            GetRegisterAthleteUrlServiceInterface::class => GetRegisterAthleteUrlService::class,
            ExchangeAthleteCodeInterface::class => ExchangeAthleteCodeService::class,
            GetAthleteClubsServiceInterface::class => GetAthleteClubsService::class,
            CommandDispatcherInterface::class => CommandDispatcher::class,
            RefreshOAuthTokenServiceInterface::class => RefreshOAuthTokenService::class,
            JwtServiceInterface::class => JwtService::class,
            GetActivitiesExternalServiceInterface::class => GetActivitiesService::class,
            GetActivityDetailExternalServiceInterface::class => GetActivityDetailService::class,
            ClientInterface::class => static function (EnvironmentInterface $env): Client {

                return new Client([
                    'scheme' => 'tcp',
                    'host' => $env->get('REDIS_HOST'),
                    'port' => $env->get('REDIS_PORT', 6379),
                    'database' => $env->get('REDIS_DB', 0),
                    'password' => $env->get('REDIS_PASSWORD'),
                ]);
            },
        ];
    }
}
