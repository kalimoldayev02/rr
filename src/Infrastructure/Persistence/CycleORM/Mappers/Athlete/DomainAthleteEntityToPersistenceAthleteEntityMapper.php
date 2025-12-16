<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Athlete;

use App\Domain\Entities\AthleteEntity;
use App\Domain\Entities\OAuthTokenEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteMetadataCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubAthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\OAuthTokenCycleORMEntity;

final readonly class DomainAthleteEntityToPersistenceAthleteEntityMapper
{
    public function map(AthleteCycleORMEntity $persistenceAthleteEntity, AthleteEntity $domainAthleteEntity): AthleteCycleORMEntity
    {
        $persistenceAthleteEntity->setId($domainAthleteEntity->getId());
        $persistenceAthleteEntity->setEmail($domainAthleteEntity->getEmail()->getValue());
        $persistenceAthleteEntity->setFirstName($domainAthleteEntity->getFirstname());
        $persistenceAthleteEntity->setLastName($domainAthleteEntity->getLastname());
        $persistenceAthleteEntity->setGender($domainAthleteEntity->getGender()->name);
        $persistenceAthleteEntity->setBirthday($domainAthleteEntity->getBirthday());
        $persistenceAthleteEntity->setPassword($domainAthleteEntity->getPassword());
        $persistenceAthleteEntity->setMetadata(
            $this->collectMetadata($persistenceAthleteEntity, $domainAthleteEntity),
        );
        $persistenceAthleteEntity->setOAuthTokens(
            $this->collectOAuthTokens($persistenceAthleteEntity, $domainAthleteEntity),
        );

        $persistenceAthleteEntity->setClubAthletes(
            $this->collectClubAthletes($persistenceAthleteEntity, $domainAthleteEntity),
        );
        if ($persistenceAthleteEntity->getCreatedAt() === null) {
            $persistenceAthleteEntity->setCreatedAt(new \DateTimeImmutable());
        }
        $persistenceAthleteEntity->setUpdatedAt(new \DateTimeImmutable());

        return $persistenceAthleteEntity;
    }

    /**
     * @return ClubAthleteCycleORMEntity[]
     */
    public function collectClubAthletes(AthleteCycleORMEntity $persistenceAthleteEntity, AthleteEntity $domainAthleteEntity): array
    {
        $clubAthletesToPersist = [];
        $currentClubAthletesMap = [];

        foreach ($persistenceAthleteEntity->getClubAthletes() as $clubAthleteEntity) {
            /** @var ClubAthleteCycleORMEntity $clubAthleteEntity */
            $currentClubAthletesMap[$clubAthleteEntity->getClubId()->toString()] = $clubAthleteEntity;
        }

        foreach ($domainAthleteEntity->getClubIds() as $clubId) {
            if ($currentClubAthlete = $currentClubAthletesMap[$clubId->toString()] ?? null) {
                $clubAthletesToPersist[] = $currentClubAthlete;
            } else {
                $clubAthletesToPersist[] = new ClubAthleteCycleORMEntity(
                    clubId: $clubId,
                    userId: $domainAthleteEntity->getId(),
                );
            }
        }

        return $clubAthletesToPersist;
    }

    private function collectMetadata(AthleteCycleORMEntity $persistenceAthleteEntity, AthleteEntity $domainAthleteEntity): ?AthleteMetadataCycleORMEntity
    {
        if ($metaData = $persistenceAthleteEntity->getMetadata()) {
            $metaData->setExternalId($domainAthleteEntity->getExternalId());
        } else {
            $metaData = new AthleteMetadataCycleORMEntity(
                userId: $domainAthleteEntity->getId(),
                externalId: $domainAthleteEntity->getExternalId(),
            );
        }
        return $metaData;
    }

    /**
     * @return OAuthTokenCycleORMEntity[]
     */
    private function collectOAuthTokens(AthleteCycleORMEntity $persistenceAthleteEntity, AthleteEntity $domainAthleteEntity): array
    {
        $tokensToPersist = [];
        $currentTokensMap = [];

        foreach ($persistenceAthleteEntity->getOAuthTokens() as $persistTokenEntity) {
            /** @var OAuthTokenCycleORMEntity $persistTokenEntity */
            $currentTokensMap[$persistTokenEntity->getId()->toString()] = $persistTokenEntity;
        }

        /** @var OAuthTokenEntity $oAuthTokenEntity */
        foreach ($domainAthleteEntity->getOAuthTokens() as $oAuthTokenEntity) {
            if ($currentTokenEntity = $currentTokensMap[$oAuthTokenEntity->getId()->toString()] ?? null) {
                $tokensToPersist[] = $currentTokenEntity;
            } else {
                $tokensToPersist[] = new OAuthTokenCycleORMEntity(
                    id: $oAuthTokenEntity->getId(),
                    athlete: $persistenceAthleteEntity,
                    provider: $oAuthTokenEntity->getProvider()->name,
                    accessToken: $oAuthTokenEntity->getAccessToken(),
                    refreshToken: $oAuthTokenEntity->getRefreshToken(),
                    expiresAt: $oAuthTokenEntity->getExpiresAt(),
                );
            }
        }

        return $tokensToPersist;
    }
}
