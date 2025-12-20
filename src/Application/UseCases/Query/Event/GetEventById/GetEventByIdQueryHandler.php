<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Event\GetEventById;

use App\Application\DTO\Event\EventDTO;
use App\Application\Mappers\Event\EventAggregateToEventDTOMapper;
use App\Application\Services\Event\CollectEventsExtraData\CollectEventExtraDataService;
use App\Domain\Collections\EventCollection;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class GetEventByIdQueryHandler
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private CollectEventExtraDataService $collectEventExtraDataService,
        private EventAggregateToEventDTOMapper $toEventDTOMapper,
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function handle(GetEventByIdQuery $query): EventDTO
    {
        $athleteEntity = $this->athleteRepository->getById($query->userId);
        $eventAggregate = $this->eventRepository->getById($query->id);

        if (\in_array($eventAggregate->getClubId(), $athleteEntity->getClubIds()->toArray(), true)) {
            throw new AccessForbiddenException('Athlete does not belong to the event club');
        }

        return $this->toEventDTOMapper->map(
            eventAggregate: $eventAggregate,
            extraData: $this->collectEventExtraDataService->collect(new EventCollection([$eventAggregate])),
        );
    }
}
