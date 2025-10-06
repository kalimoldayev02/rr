<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Club;

use App\Domain\Entities\AthleteEntity;
use App\Domain\Entities\ClubEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubSportTypeCycleORMEntity;
use Cycle\ORM\ORMInterface;

final readonly class DomainClubEntityToPersistenceClubEntityMapper
{
    public function __construct(
        private ORMInterface $orm,
    ) {}

    public function map(ClubCycleORMEntity $persistenceClubEntity, ClubEntity $domainClubEntity): ClubCycleORMEntity
    {
        $persistenceClubEntity->setId($domainClubEntity->getId()->getValue());
        $persistenceClubEntity->setName($domainClubEntity->getName());
        $persistenceClubEntity->setDescription($domainClubEntity->getDescription());
        $persistenceClubEntity->setExternalId($domainClubEntity->getExternalId());
        $persistenceClubEntity->setAthletes($this->mapDomainAthletesToPersistenceAthletes(
            persistenceClubEntity: $persistenceClubEntity,
            domainClubEntity: $domainClubEntity,
        ));
        $persistenceClubEntity->setSportTypes($this->mapDomainClubSportTypesToPersistenceClubSportTypes(
            persistenceClubEntity: $persistenceClubEntity,
            domainClubEntity: $domainClubEntity,
        ));

        return $persistenceClubEntity;
    }

    private function mapDomainAthletesToPersistenceAthletes(ClubCycleORMEntity $persistenceClubEntity, ClubEntity $domainClubEntity): array
    {
        $athleteIds = [];
        /** @var AthleteEntity $domainAthleteEntity */
        foreach ($domainClubEntity->getAthletes() as $domainAthleteEntity) {
            $athleteIds[] = $domainAthleteEntity->getId()->getValue()->toString();
        }

        if ($athleteIds) {
            return $this->orm->getRepository(AthleteCycleORMEntity::class)
                ->select()
                ->andWhere('id', 'IN', $athleteIds)
                ->fetchAll();
        }
        return [];
    }

    private function mapDomainClubSportTypesToPersistenceClubSportTypes(ClubCycleORMEntity $persistenceClubEntity, ClubEntity $domainClubEntity): array
    {
        $result = [];
        $currentClubSportTypesMap = [];
        /** @var ClubSportTypeCycleORMEntity $sportType */
        foreach ($persistenceClubEntity->getSportTypes() as $sportType) {
            $currentClubSportTypesMap[$sportType->getType()] = $sportType;
        }

        foreach ($domainClubEntity->getSportTypes() as $sportType) {
            if ($currentClubSportType = $currentClubSportTypesMap[$sportType->name] ?? null) {
                $result[] = $currentClubSportType;
            } else {
                $result[] = new ClubSportTypeCycleORMEntity(
                    clubId: $domainClubEntity->getId()->getValue(),
                    type: $sportType->name,
                );
            }
        }

        return $result;
    }
}
