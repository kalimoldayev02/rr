<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\RefreshAthleteOAuthToken;

use App\Domain\Entities\AthleteEntity;
use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Services\OAuthToken\EnsureFreshOAuthToken\EnsureFreshOAuthTokenService;

final readonly class RefreshAthleteOAuthTokenService
{
    public function __construct(
        private EnsureFreshOAuthTokenService $ensureFreshOAuthTokenService,
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function refreshIfExpired(
        AthleteEntity $athleteEntity,
        OAuthTokenProviderEnum $provider = OAuthTokenProviderEnum::strava,
    ): OAuthTokenEntity {
        $oAuthTokenEntity = $athleteEntity->getOAuthTokens()->getByProvider($provider);
        if ($oAuthTokenEntity->isExpired()) {
            $freshTokenEntity = $this->ensureFreshOAuthTokenService->ensure($oAuthTokenEntity);
            $athleteEntity->getOAuthTokens()->replace($freshTokenEntity);

            $this->athleteRepository->update($athleteEntity);

            return $freshTokenEntity;
        }

        return $oAuthTokenEntity;
    }
}
