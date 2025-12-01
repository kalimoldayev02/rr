<?php

declare(strict_types=1);

namespace App\Application\Mappers\Activity;

use App\Application\DTO\Activity\ActivityDTO;
use App\Application\Mappers\SportType\DomainSportTypeToApplicationSportTypeMapper;
use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Entities\ActivityLapEntity;
use App\Domain\Entities\ActivitySplitEntity;

final readonly class ActivityAggregateToActivityDTOMapper
{
    public function __construct(
        private ActivitySplitEntityToActivitySplitDTOMapper $toActivitySplitDTOMapper,
        private ActivityLapEntityToActivityLapDTOMapper $toActivityLapDTOMapper,
        private DomainSportTypeToApplicationSportTypeMapper $toApplicationSportTypeMapper,
    ) {}

    public function map(ActivityAggregate $activityAggregate): ActivityDTO
    {
        return new ActivityDTO(
            id: $activityAggregate->getId(),
            athleteId: $activityAggregate->getAthleteId(),
            name: $activityAggregate->getName(),
            distance: $activityAggregate->getDistance(),
            movingTime: $activityAggregate->getMovingTime(),
            elapsedTime: $activityAggregate->getElapsedTime(),
            sportType: $this->toApplicationSportTypeMapper->map($activityAggregate->getSportType()),
            startDate: $activityAggregate->getStartDate(),
            summaryPolyline: $activityAggregate->getSummaryPolyline(),
            splits: \array_map(
                fn(ActivitySplitEntity $activitySplitEntity) => $this->toActivitySplitDTOMapper->map($activitySplitEntity),
                $activityAggregate->getSplits()->toArray(),
            ),
            laps: \array_map(
                fn(ActivityLapEntity $activityLapEntity) => $this->toActivityLapDTOMapper->map($activityLapEntity),
                $activityAggregate->getLaps()->toArray(),
            ),
        );
    }
}
