<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Event;

use App\Application\DTO\Event\EventDTO;
use App\Application\DTO\Event\EventResultDTO;
use App\Endpoint\Http\Responses\Event\DetailEventResponse;

final readonly class EventDTOToDetailEventResponseMapper
{
    public function __construct(
        private EventResultDTOToEventResultResponseMapper $toEventResultResponseMapper,
    ) {}

    public function map(EventDTO $event): DetailEventResponse
    {
        return new DetailEventResponse(
            id: $event->id,
            clubId: $event->clubId,
            date: $event->date->format('c'),
            title: $event->title,
            results: \array_map(fn(EventResultDTO $result) => $this->toEventResultResponseMapper->map($result), $event->results),
        );
    }
}
