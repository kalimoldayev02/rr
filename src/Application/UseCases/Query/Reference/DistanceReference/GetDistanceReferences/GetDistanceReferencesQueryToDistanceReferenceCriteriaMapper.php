<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Reference\DistanceReference\GetDistanceReferences;

use App\Application\Mappers\Pagination\PaginationQueryToPaginationCriteriaMapper;
use App\Application\Mappers\Sort\SortQueryToSortCriteriaMapper;
use App\Application\UseCases\Query\SortQuery;
use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceCriteriaInterface;
use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceQueryCriteria;

final readonly class GetDistanceReferencesQueryToDistanceReferenceCriteriaMapper
{
    public function __construct(
        private SortQueryToSortCriteriaMapper $toSortCriteriaMapper,
        private PaginationQueryToPaginationCriteriaMapper $toPaginationCriteriaMapper,
    ) {}

    public function map(GetDistanceReferencesQuery $query): DistanceReferenceCriteriaInterface
    {
        return new DistanceReferenceQueryCriteria(
            ids: $query->ids,
            fromDistance: $query->fromDistance,
            toDistance: $query->toDistance,
            distanceTypes: $query->distanceTypes,
            sorts: $query->sorts ? \array_map(
                fn(SortQuery $sortQuery) => $this->toSortCriteriaMapper->map($sortQuery),
                $query->sorts,
            ) : null,
            pagination: $query->pagination ? $this->toPaginationCriteriaMapper->map($query->pagination) : null,
        );
    }
}
