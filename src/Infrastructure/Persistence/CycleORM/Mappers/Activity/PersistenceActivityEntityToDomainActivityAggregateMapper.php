<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Activity;

use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Collections\ActivityLapCollection;
use App\Domain\Collections\ActivitySplitCollection;
use App\Domain\Entities\ActivityLapEntity;
use App\Domain\Entities\ActivitySplitEntity;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use App\Infrastructure\Persistence\CycleORM\Entities\ActivityCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ActivityDetailCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Sort\SportTypeValueToDomainSportTypeMapper;
use Ramsey\Uuid\Uuid;

final readonly class PersistenceActivityEntityToDomainActivityAggregateMapper
{
    public function __construct(
        private SportTypeValueToDomainSportTypeMapper $toDomainSportTypeMapper,
    ) {}

    public function map(ActivityCycleORMEntity $persistenceEntity): ActivityAggregate
    {
        $domainAggregate = new ActivityAggregate(
            id: $persistenceEntity->getId(),
            externalId: $persistenceEntity->getExternalId(),
            athleteId: $persistenceEntity->getAthleteId(),
            name: $persistenceEntity->getName(),
            distance: new DistanceVO($persistenceEntity->getDistance(), DistanceTypeEnum::meters),
            movingTime: new DurationVO($persistenceEntity->getMovingTime(), DurationTypeEnum::seconds),
            elapsedTime: new DurationVO($persistenceEntity->getElapsedTime(), DurationTypeEnum::seconds),
            sportType: $this->toDomainSportTypeMapper->map($persistenceEntity->getSportType()),
            startDate: $persistenceEntity->getStartDate(),
            summaryPolyline: $persistenceEntity->getSummaryPolyline(),
        );

        if ($persistenceEntity->getDetail()) {
            $domainAggregate->setLaps($this->collectLaps($persistenceEntity->getDetail()));
            $domainAggregate->setSplits($this->collectSplits($persistenceEntity->getDetail()));
        }

        return $domainAggregate;
    }

    private function collectLaps(ActivityDetailCycleORMEntity $persistenceDetailEntity): ActivityLapCollection
    {
        $lapCollection = new ActivityLapCollection();
        foreach ($persistenceDetailEntity->getLaps() as $lap) {
            $lapCollection->add(new ActivityLapEntity(
                id: Uuid::fromString($lap['id']),
                externalId: $lap['external_id'],
                name: $lap['name'],
                distance: new DistanceVO($lap['distance'], DistanceTypeEnum::meters),
                movingTime: new DurationVO($lap['moving_time'], DurationTypeEnum::seconds),
                elapsedTime: new DurationVO($lap['elapsed_time'], DurationTypeEnum::seconds),
                lapIndex: $lap['lap_index'],
            ));
        }

        return $lapCollection;
    }

    private function collectSplits(ActivityDetailCycleORMEntity $persistenceDetailEntity): ActivitySplitCollection
    {
        $splitCollection = new ActivitySplitCollection();
        foreach ($persistenceDetailEntity->getSplits() as $split) {
            $splitCollection->add(new ActivitySplitEntity(
                id: Uuid::fromString($split['id']),
                distance: new DistanceVO($split['distance'], DistanceTypeEnum::meters),
                movingTime: new DurationVO($split['moving_time'], DurationTypeEnum::seconds),
                elapsedTime: new DurationVO($split['elapsed_time'], DurationTypeEnum::seconds),
                split: $split['split'],
            ));
        }

        return  $splitCollection;
    }
}
