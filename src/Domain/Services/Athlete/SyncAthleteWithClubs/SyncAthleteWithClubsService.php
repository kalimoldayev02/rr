<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\SyncAthleteWithClubs;

use App\Domain\Collections\ClubIdCollection;
use App\Domain\Criteria\Club\ClubQueryCriteria;
use App\Domain\Entities\ClubEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Exceptions\Athlete\OAuthTokenNotFoundException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\ClubRepositoryInterface;
use App\Domain\Services\Athlete\GetAthleteClubs\ClubDTO;
use App\Domain\Services\Athlete\GetAthleteClubs\GetAthleteClubsServiceInterface;
use App\Domain\ValueObjects\IdVO;
use Ramsey\Uuid\UuidInterface;
use App\Domain\Services\OAuthToken\EnsureFreshOAuthToken\EnsureFreshOAuthTokenService;

final readonly class SyncAthleteWithClubsService
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
        private GetAthleteClubsServiceInterface $getAthleteClubsService,
        private ClubRepositoryInterface $clubRepository,
        private EnsureFreshOAuthTokenService $ensureFreshOAuthTokenService,
    ) {}

    public function sync(UuidInterface $athleteId): void
    {
        $athleteEntity = $this->athleteRepository->getById($athleteId);
        if (!$oAuthTokenEntity = $athleteEntity->getOAuthTokens()->getByProvider(OAuthTokenProviderEnum::strava)) {
            throw new OAuthTokenNotFoundException();
        }

        if ($oAuthTokenEntity->isExpired()) {
            $oAuthTokenEntity = $this->ensureFreshOAuthTokenService->ensure($oAuthTokenEntity);
            $athleteEntity->getOAuthTokens()->replace($oAuthTokenEntity);
        }

        $clubs = $this->getAthleteClubsService->get($oAuthTokenEntity->getAccessToken());
        $clubIds = [];
        foreach ($clubs as $club) {
            $clubCollection = $this->clubRepository->getByCriteria(new ClubQueryCriteria(externalIds: [$club->id]));
            if (!$clubCollection->isEmpty()) {
                $clubEntity = $clubCollection->first();
            } else {
                $clubEntity = $this->createClub($club);
            }
            $clubIds[] = $clubEntity->getId();
        }

        if ($clubIds) {
            $athleteEntity->setClubIds(new ClubIdCollection($clubIds));
        }

        $this->athleteRepository->update($athleteEntity);
    }

    private function createClub(ClubDTO $club): ClubEntity
    {
        $clubEntity = new ClubEntity(
            id: new IdVO()->getValue(),
            externalId: $club->id,
            name: $club->name,
            description: $club->description,
            sportTypes: $club->sportTypes,
        );
        $this->clubRepository->create($clubEntity);

        return $clubEntity;
    }
}
