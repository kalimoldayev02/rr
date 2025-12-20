<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Event\GetEvents;

use App\Application\DTO\Pagination\PaginatedDataDTO;
use App\Application\Mappers\Event\EventAggregateToEventDTOMapper;
use App\Application\Mappers\Pagination\PaginationVOToPaginationDTOMapper;
use App\Application\Services\Event\CollectEventsExtraData\CollectEventExtraDataService;
use App\Domain\Aggregates\EventAggregate;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class GetEventsQueryHandler
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private GetEventsQueryToEventCriteriaMapper $toEventCriteriaMapper,
        private EventAggregateToEventDTOMapper $toEventDTOMapper,
        private PaginationVOToPaginationDTOMapper $toPaginationDTOMapper,
        private CollectEventExtraDataService $collectEventsExtraDataService,
    ) {}

    public function handle(GetEventsQuery $query): PaginatedDataDTO
    {
        $eventCollection = $this->eventRepository->getByCriteria(
            $this->toEventCriteriaMapper->map($query),
        );

        $extraData = $this->collectEventsExtraDataService->collect($eventCollection);

        return new PaginatedDataDTO(
            data: \array_map(
                fn(EventAggregate $eventAggregate) => $this->toEventDTOMapper->map($eventAggregate, $extraData),
                $eventCollection->toArray(),
            ),
            pagination: $this->toPaginationDTOMapper->map($eventCollection->getPagination()),
        );
    }
}
