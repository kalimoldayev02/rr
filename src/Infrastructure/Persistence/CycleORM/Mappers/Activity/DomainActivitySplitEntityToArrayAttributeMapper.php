<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Activity;

use App\Domain\Entities\ActivitySplitEntity;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;

final readonly class DomainActivitySplitEntityToArrayAttributeMapper
{
    public function map(ActivitySplitEntity $domainActivitySplitEntity): array
    {
        return [
            'id' => $domainActivitySplitEntity->getId()->toString(),
            'distance' => $domainActivitySplitEntity->getDistance()->getValueAs(DistanceTypeEnum::meters),
            'moving_time' => $domainActivitySplitEntity->getMovingTime()->getValueAs(DurationTypeEnum::seconds),
            'elapsed_time' => $domainActivitySplitEntity->getElapsedTime()->getValueAs(DurationTypeEnum::seconds),
            'split' => $domainActivitySplitEntity->getSplit(),
        ];
    }
}
