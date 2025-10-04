<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Club;

use App\Domain\Entities\ClubEntity;
use App\Domain\Enums\Club\SportTypeEnum;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubSportTypeCycleORMEntity;

final readonly class DomainClubEntityToPersistenceClubEntityMapper
{
    public function map(ClubCycleORMEntity $persistenceClubEntity, ClubEntity $domainClubEntity): ClubCycleORMEntity
    {
        $persistenceClubEntity->setId($domainClubEntity->getId()->getValue());
        $persistenceClubEntity->setName($domainClubEntity->getName());
        $persistenceClubEntity->setDescription($domainClubEntity->getDescription());
        $persistenceClubEntity->setExternalId($domainClubEntity->getExternalId());
        $persistenceClubEntity->setSportTypes(\array_map(static fn(SportTypeEnum $sportType) => new ClubSportTypeCycleORMEntity(
            clubId: $domainClubEntity->getId()->getValue(),
            type: $sportType->name,
        ), $domainClubEntity->getSportTypes()));

        return $persistenceClubEntity;
    }
}
