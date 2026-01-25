<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Activity;

use App\Application\DTO\Activity\ActivityDTO;
use App\Application\DTO\Activity\ActivityLapDTO;
use App\Application\DTO\Activity\ActivitySplitDTO;
use App\Endpoint\Http\Mappers\ApplicationSportTypeToEndpointSportTypeMapper;
use App\Endpoint\Http\Responses\Activity\ActivityDetailResponse;

final readonly class ActivityDTOToActivityDetailResponseMapper
{
    public function __construct(
        private DistanceVOToDistanceResponseMapper $toDistanceResponseMapper,
        private DurationVOToDurationResponseMapper $toDurationResponseMapper,
        private ApplicationSportTypeToEndpointSportTypeMapper $toEndpointSportTypeMapper,
        private ActivityLapDTOToActivityLapResponseMapper $toActivityLapResponseMapper,
        private ActivitySplitDTOToActivitySplitResponseMapper $toActivitySplitResponseMapper,
    ) {}

    public function map(ActivityDTO $activity): ActivityDetailResponse
    {
        return new ActivityDetailResponse(
            id: $activity->id,
            athleteId: $activity->athleteId,
            name: $activity->name,
            distance: $this->toDistanceResponseMapper->map($activity->distance),
            movingTime: $this->toDurationResponseMapper->map($activity->movingTime),
            elapsedTime: $this->toDurationResponseMapper->map($activity->elapsedTime),
            sportType: $this->toEndpointSportTypeMapper->map($activity->sportType),
            startDate: $activity->startDate->format('c'),
            summaryPolyline: $activity->summaryPolyline,
            laps: \array_map(
                fn(ActivityLapDTO $activityLap) => $this->toActivityLapResponseMapper->map($activityLap),
                $activity->laps,
            ),
            splits: \array_map(
                fn(ActivitySplitDTO $activitySplit) => $this->toActivitySplitResponseMapper->map($activitySplit),
                $activity->splits,
            ),
        );
    }
}
