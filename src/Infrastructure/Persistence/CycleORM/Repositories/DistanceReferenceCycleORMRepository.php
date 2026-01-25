<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\DistanceReferenceCollection;
use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceCriteriaInterface;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Exceptions\References\DistanceReference\DistanceReferenceNotFound;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Mappers\Reference\DistanceReference\DistanceReferenceCriteriaMapperInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\DistanceReferenceCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\References\DistanceReference\DomainDistanceReferenceToPersistenceDistanceReferenceEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\References\DistanceReference\PersistenceDistanceReferenceEntityToDomainDistanceReferenceMapper;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;
use Ramsey\Uuid\UuidInterface;

class DistanceReferenceCycleORMRepository extends Repository implements DistanceReferenceRepositoryInterface
{
    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly PersistenceDistanceReferenceEntityToDomainDistanceReferenceMapper $toDomainDistanceReferenceMapper,
        private readonly DomainDistanceReferenceToPersistenceDistanceReferenceEntityMapper $toPersistenceDistanceReferenceMapper,
        private readonly DistanceReferenceCriteriaMapperInterface $criteriaMapper,
    ) {
        parent::__construct($select);
    }

    public function create(DistanceReferenceEntity $distanceReferenceEntity): void
    {
        $persistenceDistanceReferenceEntity = new DistanceReferenceCycleORMEntity(
            id: $distanceReferenceEntity->getId(),
            distance: $distanceReferenceEntity->getDistance()->getValueAs(type: DistanceTypeEnum::meters),
            distanceType: DistanceTypeEnum::meters->name,
        );

        $this->entityManager->persist($this->toPersistenceDistanceReferenceMapper->map(
            persistenceDistanceReferenceEntity: $persistenceDistanceReferenceEntity,
            domainDistanceReferenceEntity: $distanceReferenceEntity,
        ));
        $this->entityManager->run();
    }

    public function update(DistanceReferenceEntity $eventDistanceReferenceEntity): void
    {
        $this->entityManager->persist($this->toPersistenceDistanceReferenceMapper->map(
            persistenceDistanceReferenceEntity: $this->get($eventDistanceReferenceEntity->getId()),
            domainDistanceReferenceEntity: $eventDistanceReferenceEntity,
        ));
        $this->entityManager->run();
    }

    public function delete(DistanceReferenceEntity $eventDistanceReferenceEntity): void
    {
        $this->entityManager->delete($this->get($eventDistanceReferenceEntity->getId()));
        $this->entityManager->run();
    }

    /**
     * @throws DistanceReferenceNotFound
     */
    public function getById(UuidInterface $id): DistanceReferenceEntity
    {
        return $this->toDomainDistanceReferenceMapper->map($this->get($id));
    }

    public function getByCriteria(DistanceReferenceCriteriaInterface $criteria): DistanceReferenceCollection
    {
        $select = $this->criteriaMapper->getSelect($criteria, $this->select());

        $totalCountQuery = clone $select;
        if ($criteria->pagination) {
            $offset = ($criteria->pagination->page - 1) * $criteria->pagination->pageSize;
            $select->limit($criteria->pagination->pageSize)->offset($offset);
        }

        $data = $select->fetchAll();

        return new DistanceReferenceCollection(
            data: \array_map(fn(DistanceReferenceCycleORMEntity $distanceReferenceEntity) => $this->toDomainDistanceReferenceMapper->map(
                persistenceDistanceReferenceEntity: $distanceReferenceEntity,
            ), $data),
            pagination: new PaginationVO(
                page: $criteria->pagination?->page ?? 1,
                pageSize: $criteria->pagination?->pageSize ?? \count($data),
                totalCount: $totalCountQuery->count(),
            ),
        );
    }

    /**
     * @throws DistanceReferenceNotFound
     */
    private function get(UuidInterface $id): DistanceReferenceCycleORMEntity
    {
        if (!$data = $this->select()->wherePK($id)->fetchOne()) {
            throw new DistanceReferenceNotFound();
        }
        return $data;
    }
}
