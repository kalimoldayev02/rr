<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Activity\GetActivities;

use App\Application\Mappers\Pagination\PaginationQueryToPaginationCriteriaMapper;
use App\Application\Mappers\Sort\SortQueryToSortCriteriaMapper;
use App\Application\UseCases\Query\SortQuery;
use App\Domain\Criteria\Activity\ActivityCriteriaInterface;
use App\Domain\Criteria\Activity\ActivityQueryCriteria;

final readonly class GetActivitiesQueryToActivityCriteriaMapper
{
    public function __construct(
        private SortQueryToSortCriteriaMapper $toSortCriteriaMapper,
        private PaginationQueryToPaginationCriteriaMapper $toPaginationCriteriaMapper,
    ) {}

    public function map(GetActivitiesQuery $query): ActivityCriteriaInterface
    {
        return new ActivityQueryCriteria(
            athleteIds: $query->athleteIds,
            fromDate: $query->fromDate,
            toDate: $query->toDate,
            sorts: $query->sorts ? \array_map(
                fn(SortQuery $sortQuery) => $this->toSortCriteriaMapper->map($sortQuery),
                $query->sorts,
            ) : null,
            pagination: $query->pagination ? $this->toPaginationCriteriaMapper->map($query->pagination) : null,
        );
    }
}
