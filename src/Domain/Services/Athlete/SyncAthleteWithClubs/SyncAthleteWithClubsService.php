<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\SyncAthleteWithClubs;

use App\Application\Enums\Access\RoleEnum;
use App\Domain\Collections\ClubIdCollection;
use App\Domain\Criteria\Club\ClubQueryCriteria;
use App\Domain\Entities\ClubEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Exceptions\Athlete\OAuthTokenNotFoundException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\ClubRepositoryInterface;
use App\Domain\Services\Athlete\GetAthleteClubs\ClubDTO;
use App\Domain\Services\Athlete\GetAthleteClubs\GetAthleteClubsServiceInterface;
use App\Domain\Services\Athlete\RefreshAthleteOAuthToken\RefreshAthleteOAuthTokenService;
use App\Domain\ValueObjects\AthleteRoleVO;
use App\Domain\ValueObjects\IdVO;
use Ramsey\Uuid\UuidInterface;

final readonly class SyncAthleteWithClubsService
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
        private GetAthleteClubsServiceInterface $getAthleteClubsService,
        private ClubRepositoryInterface $clubRepository,
        private RefreshAthleteOAuthTokenService $refreshTokenService,
    ) {}

    public function sync(UuidInterface $athleteId): void
    {
        $athleteEntity = $this->athleteRepository->getById($athleteId);
        if (!$athleteEntity->getOAuthTokens()->getByProvider(OAuthTokenProviderEnum::strava)) {
            throw new OAuthTokenNotFoundException();
        }
        $oAuthTokenEntity = $this->refreshTokenService->refreshIfExpired($athleteEntity);

        $clubs = $this->getAthleteClubsService->get($oAuthTokenEntity->getAccessToken());
        $clubIds = [];
        foreach ($clubs as $club) {
            $clubCollection = $this->clubRepository->getByCriteria(new ClubQueryCriteria(externalIds: [$club->id]));
            if (!$clubCollection->isEmpty()) {
                $clubEntity = $clubCollection->first();
            } else {
                $clubEntity = $this->createClub($club);
                $athleteEntity->addRole(new AthleteRoleVO(clubId: $clubEntity->getId(), roleId: RoleEnum::admin));
            }
            // TODO
            if ($clubEntity->getOwnerExternalId() === $athleteEntity) {
                $athleteEntity->addRole(new AthleteRoleVO(clubId: $clubEntity->getId(), roleId: RoleEnum::owner));
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
            ownerExternalId: $club->ownerExternalId,
        );
        $this->clubRepository->create($clubEntity);

        return $clubEntity;
    }
}
