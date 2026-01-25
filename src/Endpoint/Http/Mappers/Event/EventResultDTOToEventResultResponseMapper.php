<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Event;

use App\Application\DTO\Event\EventResultDTO;
use App\Endpoint\Http\Mappers\Activity\DistanceVOToDistanceResponseMapper;
use App\Endpoint\Http\Mappers\Activity\DurationVOToDurationResponseMapper;
use App\Endpoint\Http\Mappers\Athlete\AthleteDTOToAthleteResponseMapper;
use App\Endpoint\Http\Responses\Event\EventResultResponse;

final readonly class EventResultDTOToEventResultResponseMapper
{
    public function __construct(
        private AthleteDTOToAthleteResponseMapper $toAthleteResponseMapper,
        private DurationVOToDurationResponseMapper $toDurationResponseMapper,
        private DistanceVOToDistanceResponseMapper $toDistanceResponseMapper,
    ) {}

    public function map(EventResultDTO $eventResult): EventResultResponse
    {
        return new EventResultResponse(
            id: $eventResult->id,
            athlete: $this->toAthleteResponseMapper->map($eventResult->athlete),
            activityId: $eventResult->activityId,
            duration: $this->toDurationResponseMapper->map($eventResult->duration),
            distance: $this->toDistanceResponseMapper->map($eventResult->distance->distance),
        );
    }
}
