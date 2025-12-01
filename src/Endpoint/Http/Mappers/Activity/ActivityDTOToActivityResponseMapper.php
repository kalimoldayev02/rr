<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Activity;

use App\Application\DTO\Activity\ActivityDTO;
use App\Endpoint\Http\Mappers\ApplicationSportTypeToEndpointSportTypeMapper;
use App\Endpoint\Http\Responses\Activity\ActivityResponse;

final readonly class ActivityDTOToActivityResponseMapper
{
    public function __construct(
        private DistanceVOToDistanceResponseMapper $toDistanceResponseMapper,
        private DurationVOToDurationResponseMapper $toDurationResponseMapper,
        private ApplicationSportTypeToEndpointSportTypeMapper $toEndpointSportTypeMapper,
    ) {}

    public function map(ActivityDTO $activity): ActivityResponse
    {
        return new ActivityResponse(
            id: $activity->id,
            athleteId: $activity->athleteId,
            name: $activity->name,
            distance: $this->toDistanceResponseMapper->map($activity->distance),
            movingTime: $this->toDurationResponseMapper->map($activity->movingTime),
            elapsedTime: $this->toDurationResponseMapper->map($activity->elapsedTime),
            sportType: $this->toEndpointSportTypeMapper->map($activity->sportType),
            startDate: $activity->startDate->format('c'),
            summaryPolyline: $activity->summaryPolyline,
        );
    }
}
