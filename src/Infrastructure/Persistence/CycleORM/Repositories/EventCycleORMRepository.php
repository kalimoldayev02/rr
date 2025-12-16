<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Aggregates\EventAggregate;
use App\Domain\Exceptions\Event\EventNotFoundException;
use App\Domain\Repositories\EventRepositoryInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\EventCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Event\Event\DomainEventAggregateToPersistenceEventEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Event\Event\PersistenceEventEntityToDomainEventAggregateMapper;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;
use Ramsey\Uuid\UuidInterface;

class EventCycleORMRepository extends Repository implements EventRepositoryInterface
{
    private const array RELATIONS = ['results'];

    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly PersistenceEventEntityToDomainEventAggregateMapper $toDomainEventAggregateMapper,
        private readonly DomainEventAggregateToPersistenceEventEntityMapper $toPersistenceEventEntityMapper,
    ) {
        parent::__construct($select);
    }

    public function create(EventAggregate $eventAggregate): void
    {
        $persistenceEventEntity = new EventCycleORMEntity(
            id: $eventAggregate->getId(),
            authorId: $eventAggregate->getAuthorId(),
            clubId: $eventAggregate->getClubId(),
            date: $eventAggregate->getDate(),
            title: $eventAggregate->getTitle(),
        );

        $this->entityManager->persist($this->toPersistenceEventEntityMapper->map(
            persistenceEventEntity: $persistenceEventEntity,
            domainEventAggregate: $eventAggregate,
        ));
        $this->entityManager->run();
    }

    public function update(EventAggregate $eventAggregate): void
    {
        $this->entityManager->persist($this->toPersistenceEventEntityMapper->map(
            persistenceEventEntity: $this->get($eventAggregate->getId()),
            domainEventAggregate: $eventAggregate,
        ));
        $this->entityManager->run();
    }

    public function delete(EventAggregate $eventAggregate): void
    {
        $this->entityManager->delete($this->get($eventAggregate->getId()));
        $this->entityManager->run();
    }

    /**
     * @throws EventNotFoundException
     */
    public function getById(UuidInterface $id): EventAggregate
    {
        return $this->toDomainEventAggregateMapper->map($this->get($id));
    }

    /**
     * @throws EventNotFoundException
     */
    private function get(UuidInterface $id): EventCycleORMEntity
    {
        if (!$data = $this->select()->wherePK($id)->load(self::RELATIONS)->fetchOne()) {
            throw new EventNotFoundException();
        }
        return $data;
    }
}
