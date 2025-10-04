<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers\Strava;

use App\Infrastructure\Providers\ServiceConfiguratorInterface;

final readonly class StravaProviderConfig
{
    public function __construct(
        private ServiceConfiguratorInterface $configurator,
    ) {}

    public function getUrl(): string
    {
        return $this->configurator->get('strava', 'url');
    }

    public function getApiUtl(): string
    {
        return $this->configurator->get('strava', 'apiUrl');
    }

    public function getClientId(): string
    {
        return $this->configurator->get('strava', 'client_id');
    }

    public function getClientSecret(): string
    {
        return $this->configurator->get('strava', 'client_secret');
    }

    public function getRedirectUri(): string
    {
        return $this->configurator->get('strava', 'redirect_uri');
    }

    public function getTimeout(): int
    {
        return $this->configurator->get('strava', 'timeout', 10);
    }
}
