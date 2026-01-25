<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Activity;

use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Entities\ActivityLapEntity;
use App\Domain\Entities\ActivitySplitEntity;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Infrastructure\Persistence\CycleORM\Entities\ActivityCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ActivityDetailCycleORMEntity;

final readonly class DomainActivityAggregateToPersistenceActivityEntityMapper
{
    public function __construct(
        private DomainActivityLapEntityToArrayAttributeMapper $toArrayAttributeLapMapper,
        private DomainActivitySplitEntityToArrayAttributeMapper $toArrayAttributeSplitMapper,
    ) {}

    public function map(ActivityCycleORMEntity $persistenceEntity, ActivityAggregate $domainAggregate): ActivityCycleORMEntity
    {
        $persistenceEntity->setId($domainAggregate->getId());
        $persistenceEntity->setName($domainAggregate->getName());
        $persistenceEntity->setExternalId($domainAggregate->getExternalId());
        $persistenceEntity->setDistance($domainAggregate->getDistance()->getValueAs(DistanceTypeEnum::meters));
        $persistenceEntity->setMovingTime($domainAggregate->getMovingTime()->getValueAs(DurationTypeEnum::seconds));
        $persistenceEntity->setElapsedTime($domainAggregate->getElapsedTime()->getValueAs(DurationTypeEnum::seconds));
        $persistenceEntity->setSportType($domainAggregate->getSportType()->name);
        $persistenceEntity->setStartDate($domainAggregate->getStartDate());
        $persistenceEntity->setSummaryPolyline($domainAggregate->getSummaryPolyline());
        $persistenceEntity->setDetail($this->collectActivityDetail($persistenceEntity, $domainAggregate));

        return $persistenceEntity;
    }

    private function collectActivityDetail(ActivityCycleORMEntity $persistenceEntity, ActivityAggregate $domainAggregate): ActivityDetailCycleORMEntity|null
    {
        if ($persistenceDetailEntity = $persistenceEntity->getDetail() ?? null) {
            $persistenceDetailEntity->setLaps(\array_map(
                fn(ActivityLapEntity $domainActivityLapEntity) => $this->toArrayAttributeLapMapper->map($domainActivityLapEntity),
                $domainAggregate->getLaps()->toArray(),
            ));

            $persistenceDetailEntity->setSplits(\array_map(
                fn(ActivitySplitEntity $domainActivitySplitEntity) => $this->toArrayAttributeSplitMapper->map($domainActivitySplitEntity),
                $domainAggregate->getSplits()->toArray(),
            ));

            return $persistenceDetailEntity;
        }
        if (!($domainAggregate->getSplits()->isEmpty() && $domainAggregate->getLaps()->isEmpty())) {
            return new ActivityDetailCycleORMEntity(
                activityId: $domainAggregate->getId(),
                laps: \array_map(
                    fn(ActivityLapEntity $domainActivityLapEntity) => $this->toArrayAttributeLapMapper->map($domainActivityLapEntity),
                    $domainAggregate->getLaps()->toArray(),
                ),
                splits: \array_map(
                    fn(ActivitySplitEntity $domainActivitySplitEntity) => $this->toArrayAttributeSplitMapper->map($domainActivitySplitEntity),
                    $domainAggregate->getSplits()->toArray(),
                ),
            );
        }
        return null;
    }


}
