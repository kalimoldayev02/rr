<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Event\EventResult;

use App\Domain\Entities\EventResultEntity;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Domain\ValueObjects\DurationVO;
use App\Infrastructure\Persistence\CycleORM\Entities\EventResultCycleORMEntity;

final readonly class PersistenceEventResultEntityToDomainEventResultMapper
{
    public function map(EventResultCycleORMEntity $persistenceEventResultEntity): EventResultEntity
    {
        return new EventResultEntity(
            id: $persistenceEventResultEntity->getId(),
            athleteId: $persistenceEventResultEntity->getAthleteId(),
            activityId: $persistenceEventResultEntity->getActivityId(),
            distanceReferenceId: $persistenceEventResultEntity->getDistanceReferenceId(),
            duration: new DurationVO(
                value: $persistenceEventResultEntity->getDuration(),
                type: match ($persistenceEventResultEntity->getDurationType()) {
                    DurationTypeEnum::seconds->name => DurationTypeEnum::seconds,
                    DurationTypeEnum::minutes->name => DurationTypeEnum::minutes,
                },
            ),
        );
    }
}
