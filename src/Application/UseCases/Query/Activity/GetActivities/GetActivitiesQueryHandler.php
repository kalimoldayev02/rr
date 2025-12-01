<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Activity\GetActivities;

use App\Application\DTO\Pagination\PaginatedDataDTO;
use App\Application\Mappers\Pagination\PaginationVOToPaginationDTOMapper;
use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Repositories\ActivityRepositoryInterface;
use App\Application\Mappers\Activity\ActivityAggregateToActivityDTOMapper;

final readonly class GetActivitiesQueryHandler
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private GetActivitiesQueryToActivityCriteriaMapper $toActivityCriteriaMapper,
        private ActivityAggregateToActivityDTOMapper $toActivityDTOMapper,
        private PaginationVOToPaginationDTOMapper $toPaginationDTOMapper,
    ) {}

    public function handle(GetActivitiesQuery $query): PaginatedDataDTO
    {
        $activityCollection = $this->activityRepository->getByCriteria($this->toActivityCriteriaMapper->map($query));

        return new PaginatedDataDTO(
            data: \array_map(
                fn(ActivityAggregate $activityAggregate) => $this->toActivityDTOMapper->map($activityAggregate),
                $activityCollection->toArray(),
            ),
            pagination: $this->toPaginationDTOMapper->map($activityCollection->getPagination()),
        );
    }
}
