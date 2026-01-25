<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Club;

use App\Domain\Entities\ClubEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubSportTypeCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Sort\SportTypeValueToDomainSportTypeMapper;

final readonly class PersistenceClubEntityToDomainClubEntityMapper
{
    public function __construct(
        private SportTypeValueToDomainSportTypeMapper $toDomainSportTypeMapper,
    ) {}

    public function map(ClubCycleORMEntity $persistenceClubEntity): ClubEntity
    {
        return new ClubEntity(
            id: $persistenceClubEntity->getId(),
            externalId: $persistenceClubEntity->getExternalId(),
            name: $persistenceClubEntity->getName(),
            description: $persistenceClubEntity->getDescription(),
            sportTypes: $this->collectSportTypes($persistenceClubEntity->getSportTypes()),
            ownerExternalId: $persistenceClubEntity->getOwnerExternalId(),
        );
    }

    private function collectSportTypes(array $sportTypes): array
    {
        return \array_map(
            fn(ClubSportTypeCycleORMEntity $sportType) => $this->toDomainSportTypeMapper->map($sportType->getType()),
            $sportTypes,
        );
    }
}
