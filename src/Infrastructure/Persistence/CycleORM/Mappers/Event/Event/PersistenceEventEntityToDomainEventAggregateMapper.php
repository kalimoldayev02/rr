<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Event\Event;

use App\Domain\Aggregates\EventAggregate;
use App\Domain\Collections\EventResultCollection;
use App\Infrastructure\Persistence\CycleORM\Entities\EventCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Event\EventResult\PersistenceEventResultEntityToDomainEventResultMapper;

final readonly class PersistenceEventEntityToDomainEventAggregateMapper
{
    public function __construct(
        private PersistenceEventResultEntityToDomainEventResultMapper $eventResultMapper,
    ) {}

    public function map(EventCycleORMEntity $persistenceEventEntity): EventAggregate
    {
        $results = new EventResultCollection();

        foreach ($persistenceEventEntity->getResults() as $resultEntity) {
            $results->add($this->eventResultMapper->map($resultEntity));
        }

        return new EventAggregate(
            id: $persistenceEventEntity->getId(),
            clubId: $persistenceEventEntity->getClubId(),
            date: $persistenceEventEntity->getDate(),
            title: $persistenceEventEntity->getTitle(),
            results: $results,
        );
    }
}
