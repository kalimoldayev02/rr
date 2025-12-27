<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Event;

use App\Application\DTO\Event\EventDTO;
use App\Endpoint\Http\Responses\Event\EventResponse;

final readonly class EventDTOToEventResponseMapper
{
    public function map(EventDTO $eventDTO): EventResponse
    {
        return new EventResponse(
            id: $eventDTO->id,
            clubId: $eventDTO->clubId,
            date: $eventDTO->date->format('c'),
            title: $eventDTO->title,
        );
    }
}
