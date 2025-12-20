<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Event;

use App\Application\DTO\Event\EventDTO;
use App\Endpoint\Http\Mappers\Author\AthleteDTOToAuthorResponseMapper;
use App\Endpoint\Http\Responses\Event\EventResponse;

final readonly class EventDTOToEventResponseMapper
{
    public function __construct(
        public AthleteDTOToAuthorResponseMapper $toAuthorResponseMapper,
    ) {}

    public function map(EventDTO $eventDTO): EventResponse
    {
        return new EventResponse(
            id: $eventDTO->id,
            author: $this->toAuthorResponseMapper->map($eventDTO->author),
            clubId: $eventDTO->clubId,
            date: $eventDTO->date->format('c'),
            title: $eventDTO->title,
        );
    }
}
