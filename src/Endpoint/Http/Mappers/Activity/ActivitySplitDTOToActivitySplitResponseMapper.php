<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Activity;

use App\Application\DTO\Activity\ActivitySplitDTO;
use App\Endpoint\Http\Responses\Activity\ActivitySplitResponse;

final readonly class ActivitySplitDTOToActivitySplitResponseMapper
{
    public function __construct(
        private DistanceVOToDistanceResponseMapper $toDistanceResponseMapper,
        private DurationVOToDurationResponseMapper $toDurationResponseMapper,
    ) {}

    public function map(ActivitySplitDTO $activitySplit): ActivitySplitResponse
    {
        return new ActivitySplitResponse(
            distance: $this->toDistanceResponseMapper->map($activitySplit->distance),
            movingTime: $this->toDurationResponseMapper->map($activitySplit->movingTime),
            elapsedTime: $this->toDurationResponseMapper->map($activitySplit->elapsedTime),
            split: $activitySplit->split,
        );
    }
}
