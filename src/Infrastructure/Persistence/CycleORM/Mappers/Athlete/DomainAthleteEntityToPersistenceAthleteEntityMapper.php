<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Athlete;

use App\Domain\Entities\AthleteEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteMetadataCycleORMEntity;

final readonly class DomainAthleteEntityToPersistenceAthleteEntityMapper
{
    public function map(AthleteCycleORMEntity $persistenceAthleteEntity, AthleteEntity $domainAthleteEntity): AthleteCycleORMEntity
    {
        $persistenceAthleteEntity->setId($domainAthleteEntity->getId()->getValue());
        $persistenceAthleteEntity->setFirstName($domainAthleteEntity->getFirstName());
        $persistenceAthleteEntity->setLastName($domainAthleteEntity->getLastName());
        $persistenceAthleteEntity->setGender($domainAthleteEntity->getGender()->name);
        $persistenceAthleteEntity->setBirthday($domainAthleteEntity->getBirthday());
        $persistenceAthleteEntity->setMetadata(new AthleteMetadataCycleORMEntity(
            userId: $domainAthleteEntity->getId()->getValue(),
            externalId: $domainAthleteEntity->getExternalId(),
        ));

        return $persistenceAthleteEntity;
    }
}
