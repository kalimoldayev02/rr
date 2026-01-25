<?php

declare(strict_types=1);

namespace App\Application\Mappers\Activity;

use App\Application\DTO\Activity\ActivitySplitDTO;
use App\Domain\Entities\ActivitySplitEntity;

final readonly class ActivitySplitEntityToActivitySplitDTOMapper
{
    public function map(ActivitySplitEntity $activitySplitEntity): ActivitySplitDTO
    {
        return new ActivitySplitDTO(
            distance: $activitySplitEntity->getDistance(),
            movingTime: $activitySplitEntity->getMovingTime(),
            elapsedTime: $activitySplitEntity->getElapsedTime(),
            split: $activitySplitEntity->getSplit(),
        );
    }
}
