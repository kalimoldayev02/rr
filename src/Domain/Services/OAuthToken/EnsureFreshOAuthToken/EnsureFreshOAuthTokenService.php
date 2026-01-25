<?php

declare(strict_types=1);

namespace App\Domain\Services\OAuthToken\EnsureFreshOAuthToken;

use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\Criteria\OAuthToken\OAuthTokenQueryCriteria;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Exceptions\Athlete\AthleteNotFoundException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Services\OAuthToken\RefreshOAuthToken\RefreshOAuthTokenServiceInterface;

final readonly class EnsureFreshOAuthTokenService
{
    public function __construct(
        private RefreshOAuthTokenServiceInterface $refreshOAuthTokenService,
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function ensure(OAuthTokenEntity $oAuthTokenEntity): OAuthTokenEntity
    {
        $newOAuthTokenEntity =  $this->refreshOAuthTokenService->get($oAuthTokenEntity);
        $athleteCollection = $this->athleteRepository->getByCriteria(new AthleteQueryCriteria(
            oAuthTokenCriteria: new OAuthTokenQueryCriteria(providers: [$oAuthTokenEntity->getProvider()]),
        ));

        if ($athleteCollection->isEmpty()) {
            throw new AthleteNotFoundException();
        }
        /** @var AthleteEntity $athleteEntity */
        $athleteEntity = $athleteCollection->first();
        $athleteEntity->getOAuthTokens()->replace($newOAuthTokenEntity);

        return $newOAuthTokenEntity;
    }
}
