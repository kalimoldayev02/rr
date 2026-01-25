<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Event\EventResult;

use App\Domain\Entities\EventResultEntity;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Infrastructure\Persistence\CycleORM\Entities\EventResultCycleORMEntity;

final readonly class DomainEventResultToPersistenceEventResultEntityMapper
{
    public function map(EventResultCycleORMEntity $persistenceEventResultEntity, EventResultEntity $domainEventResultEntity): EventResultCycleORMEntity
    {
        $persistenceEventResultEntity->setId($domainEventResultEntity->getId());
        $persistenceEventResultEntity->setAthleteId($domainEventResultEntity->getAthleteId());
        $persistenceEventResultEntity->setActivityId($domainEventResultEntity->getActivityId());
        $persistenceEventResultEntity->setDistanceReferenceId($domainEventResultEntity->getDistanceReferenceId());
        $persistenceEventResultEntity->setDuration($domainEventResultEntity->getDuration()->getValueAs(DurationTypeEnum::seconds));
        $persistenceEventResultEntity->setDurationType(DurationTypeEnum::seconds->name);

        return $persistenceEventResultEntity;
    }
}
