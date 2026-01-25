<?php

declare(strict_types=1);

namespace App\Application\Mappers\Event;

use App\Application\DTO\Event\EventDTO;
use App\Application\Services\Event\CollectEventsExtraData\EventsExtraDataDTO;
use App\Domain\Aggregates\EventAggregate;
use App\Domain\Entities\EventResultEntity;

final readonly class EventAggregateToEventDTOMapper
{
    public function __construct(
        private EventResultEntityToEventResultDTOMapper $toEventResultDTOMapper,
    ) {}

    public function map(EventAggregate $eventAggregate, EventsExtraDataDTO $extraData): EventDTO
    {
        return new EventDTO(
            id: $eventAggregate->getId(),
            clubId: $eventAggregate->getClubId(),
            date: $eventAggregate->getDate(),
            title: $eventAggregate->getTitle(),
            results: \array_map(
                fn(EventResultEntity $eventResultEntity) => $this->toEventResultDTOMapper->map($eventResultEntity, $extraData),
                $eventAggregate->getResult()->toArray(),
            ),
        );
    }
}
