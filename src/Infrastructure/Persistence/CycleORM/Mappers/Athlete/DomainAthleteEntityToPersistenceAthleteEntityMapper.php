<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Athlete;

use App\Domain\Entities\AthleteEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteMetadataCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubAthleteCycleORMEntity;

final readonly class DomainAthleteEntityToPersistenceAthleteEntityMapper
{
    public function map(AthleteCycleORMEntity $persistenceAthleteEntity, AthleteEntity $domainAthleteEntity): AthleteCycleORMEntity
    {
        $persistenceAthleteEntity->setId($domainAthleteEntity->getId());
        $persistenceAthleteEntity->setEmail($domainAthleteEntity->getEmail()->getValue());
        $persistenceAthleteEntity->setFirstName($domainAthleteEntity->getFirstName());
        $persistenceAthleteEntity->setLastName($domainAthleteEntity->getLastName());
        $persistenceAthleteEntity->setGender($domainAthleteEntity->getGender()->name);
        $persistenceAthleteEntity->setBirthday($domainAthleteEntity->getBirthday());
        $persistenceAthleteEntity->setPassword($domainAthleteEntity->getPassword());
        $persistenceAthleteEntity->setMetadata(
            $this->collectMetadata($persistenceAthleteEntity, $domainAthleteEntity),
        );
        $persistenceAthleteEntity->setClubAthletes(
            $this->collectClubAthletes($persistenceAthleteEntity, $domainAthleteEntity),
        );

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
}
