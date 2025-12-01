<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\ActivityCollection;
use App\Domain\Criteria\Activity\ActivityCriteriaInterface;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Domain\Exceptions\Activity\ActivityNotFoundException;
use App\Domain\Repositories\ActivityRepositoryInterface;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Mappers\Activity\ActivityCriteriaMapperInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\ActivityCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Activity\DomainActivityAggregateToPersistenceActivityEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Activity\PersistenceActivityEntityToDomainActivityAggregateMapper;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;
use App\Domain\Aggregates\ActivityAggregate;
use Ramsey\Uuid\UuidInterface;

final class ActivityCycleORMRepository extends Repository implements ActivityRepositoryInterface
{
    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly ActivityCriteriaMapperInterface $criteriaMapper,
        private readonly DomainActivityAggregateToPersistenceActivityEntityMapper $toPersistenceActivityEntityMapper,
        private readonly PersistenceActivityEntityToDomainActivityAggregateMapper $toDomainActivityAggregateMapper,
    ) {
        parent::__construct($select);
    }

    public function create(ActivityAggregate $activityAggregate): void
    {
        $persistenceActivityEntity = new ActivityCycleORMEntity(
            id: $activityAggregate->getId(),
            externalId: $activityAggregate->getExternalId(),
            athleteId: $activityAggregate->getAthleteId(),
            name: $activityAggregate->getName(),
            distance: $activityAggregate->getDistance()->getValueAs(DistanceTypeEnum::meters),
            movingTime: $activityAggregate->getMovingTime()->getValueAs(DurationTypeEnum::seconds),
            elapsedTime: $activityAggregate->getElapsedTime()->getValueAs(DurationTypeEnum::seconds),
            sportType: $activityAggregate->getSportType()->name,
            startDate: $activityAggregate->getStartDate(),
            summaryPolyline: $activityAggregate->getSummaryPolyline(),
        );

        $this->entityManager->persist($this->toPersistenceActivityEntityMapper->map($persistenceActivityEntity, $activityAggregate));
        $this->entityManager->run();
    }

    public function getByCriteria(ActivityCriteriaInterface $criteria): ActivityCollection
    {
        $select = $this->criteriaMapper->getSelect($criteria, $this->select());

        $totalCountSelect = clone $select;
        if ($criteria->pagination) {
            $offset = ($criteria->pagination->page - 1) * $criteria->pagination->pageSize;
            $select->limit($criteria->pagination->pageSize)->offset($offset);
        }
        $data = $select->fetchAll();

        return new ActivityCollection(
            data: \array_map(fn(ActivityCycleORMEntity $activityEntity) => $this->toDomainActivityAggregateMapper->map($activityEntity), $data),
            pagination: new PaginationVO(
                page: $criteria->pagination?->page ?? 1,
                pageSize: $criteria->pagination?->pageSize ?? \count($data),
                totalCount: $totalCountSelect->count(),
            ),
        );
    }

    public function update(ActivityAggregate $activityAggregate): void
    {
        $this->entityManager->persist($this->toPersistenceActivityEntityMapper->map(
            persistenceEntity: $this->get($activityAggregate->getId()),
            domainAggregate: $activityAggregate,
        ));
        $this->entityManager->run();
    }

    public function getById(UuidInterface $id): ActivityAggregate
    {
        return $this->toDomainActivityAggregateMapper->map($this->get($id));
    }

    private function get(UuidInterface $id): ActivityCycleORMEntity
    {
        if (!$persistenceEntity = $this->select()->wherePK($id)->fetchOne()) {
            throw new ActivityNotFoundException();
        }
        return $persistenceEntity;
    }
}
