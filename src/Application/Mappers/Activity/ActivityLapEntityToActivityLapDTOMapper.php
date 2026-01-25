<?php

declare(strict_types=1);

namespace App\Application\Mappers\Activity;

use App\Application\DTO\Activity\ActivityLapDTO;
use App\Domain\Entities\ActivityLapEntity;

final readonly class ActivityLapEntityToActivityLapDTOMapper
{
    public function map(ActivityLapEntity $activityLapEntity): ActivityLapDTO
    {
        return new ActivityLapDTO(
            name: $activityLapEntity->getName(),
            distance: $activityLapEntity->getDistance(),
            movingTime: $activityLapEntity->getMovingTime(),
            elapsedTime: $activityLapEntity->getElapsedTime(),
            lapIndex: $activityLapEntity->getLapIndex(),
        );
    }
}
