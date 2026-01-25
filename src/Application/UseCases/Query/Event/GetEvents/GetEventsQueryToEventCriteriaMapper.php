<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Event\GetEvents;

use App\Application\Mappers\Pagination\PaginationQueryToPaginationCriteriaMapper;
use App\Application\Mappers\Sort\SortQueryToSortCriteriaMapper;
use App\Application\UseCases\Query\SortQuery;
use App\Domain\Criteria\Event\EventCriteriaInterface;
use App\Domain\Criteria\Event\EventQueryCriteria;

final readonly class GetEventsQueryToEventCriteriaMapper
{
    public function __construct(
        private SortQueryToSortCriteriaMapper $toSortCriteriaMapper,
        private PaginationQueryToPaginationCriteriaMapper $toPaginationCriteriaMapper,
    ) {}

    public function map(GetEventsQuery $query): EventCriteriaInterface
    {
        return new EventQueryCriteria(
            ids: $query->ids,
            clubIds: $query->clubIds,
            athleteIds: $query->athleteIds,
            fromDate: $query->fromDate,
            toDate: $query->toDate,
            title: $query->title,
            sorts: $query->sorts ? \array_map(
                fn(SortQuery $sortQuery) => $this->toSortCriteriaMapper->map($sortQuery),
                $query->sorts,
            ) : null,
            pagination: $this->toPaginationCriteriaMapper->map($query->pagination),
        );
    }
}
