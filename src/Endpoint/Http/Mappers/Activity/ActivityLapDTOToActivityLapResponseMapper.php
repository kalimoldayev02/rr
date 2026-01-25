<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Activity;

use App\Application\DTO\Activity\ActivityLapDTO;
use App\Endpoint\Http\Responses\Activity\ActivityLapResponse;

final readonly class ActivityLapDTOToActivityLapResponseMapper
{
    public function __construct(
        private DistanceVOToDistanceResponseMapper $toDistanceResponseMapper,
        private DurationVOToDurationResponseMapper $toDurationResponseMapper,
    ) {}

    public function map(ActivityLapDTO $activityLap): ActivityLapResponse
    {
        return new ActivityLapResponse(
            name: $activityLap->name,
            distance: $this->toDistanceResponseMapper->map($activityLap->distance),
            movingTime: $this->toDurationResponseMapper->map($activityLap->movingTime),
            elapsedTime: $this->toDurationResponseMapper->map($activityLap->elapsedTime),
            lapIndex: $activityLap->lapIndex,
        );
    }
}
