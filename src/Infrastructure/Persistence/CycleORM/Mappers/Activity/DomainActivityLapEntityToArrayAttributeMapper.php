<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Activity;

use App\Domain\Entities\ActivityLapEntity;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;

final readonly class DomainActivityLapEntityToArrayAttributeMapper
{
    public function map(ActivityLapEntity $domainActivityLapEntity): array
    {
        return [
            'id' => $domainActivityLapEntity->getId()->toString(),
            'external_id' => $domainActivityLapEntity->getExternalId(),
            'name' => $domainActivityLapEntity->getName(),
            'distance' => $domainActivityLapEntity->getDistance()->getValueAs(DistanceTypeEnum::meters),
            'moving_time' => $domainActivityLapEntity->getMovingTime()->getValueAs(DurationTypeEnum::seconds),
            'elapsed_time' => $domainActivityLapEntity->getElapsedTime()->getValueAs(DurationTypeEnum::seconds),
            'lap_index' => $domainActivityLapEntity->getLapIndex(),
        ];
    }
}
