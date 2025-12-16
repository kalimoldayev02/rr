<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Event\Event;

use App\Domain\Aggregates\EventAggregate;
use App\Domain\Entities\EventResultEntity;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Infrastructure\Persistence\CycleORM\Entities\EventCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\EventResultCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Event\EventResult\DomainEventResultToPersistenceEventResultEntityMapper;

final readonly class DomainEventAggregateToPersistenceEventEntityMapper
{
    public function __construct(
        private DomainEventResultToPersistenceEventResultEntityMapper $eventResultMapper,
    ) {}

    public function map(EventCycleORMEntity $persistenceEventEntity, EventAggregate $domainEventAggregate): EventCycleORMEntity
    {
        $persistenceEventEntity->setId($domainEventAggregate->getId());
        $persistenceEventEntity->setAuthorId($domainEventAggregate->getAuthorId());
        $persistenceEventEntity->setClubId($domainEventAggregate->getClubId());
        $persistenceEventEntity->setDate($domainEventAggregate->getDate());
        $persistenceEventEntity->setTitle($domainEventAggregate->getTitle());
        $persistenceEventEntity->setResults(
            $this->collectResults($persistenceEventEntity, $domainEventAggregate),
        );

        return $persistenceEventEntity;
    }

    /**
     * @return EventResultCycleORMEntity[]
     */
    private function collectResults(EventCycleORMEntity $persistenceEventEntity, EventAggregate $domainEventAggregate): array
    {
        $resultsToPersist = [];
        $currentResultsMap = [];

        foreach ($persistenceEventEntity->getResults() as $resultEntity) {
            /** @var EventResultCycleORMEntity $resultEntity */
            $currentResultsMap[$resultEntity->getId()->toString()] = $resultEntity;
        }

        /** @var EventResultEntity $eventResultEntity */
        foreach ($domainEventAggregate->getResult() as $eventResultEntity) {
            if ($currentResultEntity = $currentResultsMap[$eventResultEntity->getId()->toString()] ?? null) {
                $resultsToPersist[] = $this->eventResultMapper->map(
                    persistenceEventResultEntity: $currentResultEntity,
                    domainEventResultEntity: $eventResultEntity,
                );
            } else {
                $newResultEntity = new EventResultCycleORMEntity(
                    id: $eventResultEntity->getId(),
                    athleteId: $eventResultEntity->getAthleteId(),
                    activityId: $eventResultEntity->getActivityId(),
                    distanceReferenceId: $eventResultEntity->getDistanceReferenceId(),
                    duration: $eventResultEntity->getDuration()->getValueAs(DurationTypeEnum::seconds),
                    durationType: DurationTypeEnum::seconds->name,
                );
                $resultsToPersist[] = $this->eventResultMapper->map(
                    persistenceEventResultEntity: $newResultEntity,
                    domainEventResultEntity: $eventResultEntity,
                );
            }
        }

        return $resultsToPersist;
    }
}
