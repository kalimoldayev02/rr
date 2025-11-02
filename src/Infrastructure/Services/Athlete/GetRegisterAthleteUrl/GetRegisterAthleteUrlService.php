<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Athlete\GetRegisterAthleteUrl;

use App\Domain\Repositories\AuthStateRepositoryInterface;
use App\Infrastructure\Providers\Strava\StravaProviderConfig;
use App\Domain\Services\Athlete\GetRegisterAthleteUrl\GetRegisterAthleteUrlServiceInterface;

final readonly class GetRegisterAthleteUrlService implements GetRegisterAthleteUrlServiceInterface
{
    public function __construct(
        private StravaProviderConfig $stravaProviderConfig,
        private AuthStateRepositoryInterface $authStateRepository,
    ) {}

    public function get(): string
    {
        $state = $this->authStateRepository->generateState();
        $this->authStateRepository->create($state);

        $query = [
            'client_id' => $this->stravaProviderConfig->getClientId(),
            'redirect_uri' => $this->stravaProviderConfig->getRedirectUri(),
            'response_type' => 'code',
            'scope' => 'read,activity:read_all',
            'state' => $state,
        ];

        return $this->stravaProviderConfig->getUrl() . 'oauth/authorize?' . \http_build_query($query);
    }
}
