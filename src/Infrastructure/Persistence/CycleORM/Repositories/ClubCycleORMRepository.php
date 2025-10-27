<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\ClubCollection;
use App\Domain\Criteria\Club\ClubCriteriaInterface;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Entities\ClubEntity;
use App\Domain\Enums\Club\SportTypeEnum;
use App\Domain\Exceptions\Club\ClubNotFoundException;
use App\Domain\Repositories\ClubRepositoryInterface;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubSportTypeCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Club\DomainClubEntityToPersistenceClubEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Club\PersistenceClubEntityToDomainClubEntityMapper;
use Cycle\ORM\Select\Repository;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Ramsey\Uuid\UuidInterface;

class ClubCycleORMRepository extends Repository implements ClubRepositoryInterface
{
    private const array RELATIONS = ['sportTypes'];

    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly PersistenceClubEntityToDomainClubEntityMapper $toDomainClubEntityMapper,
        private readonly DomainClubEntityToPersistenceClubEntityMapper $toPersistenceClubEntityMapper,
    ) {
        parent::__construct($select);
    }

    public function create(ClubEntity $clubEntity): void
    {
        $persistenceClubEntity = new ClubCycleORMEntity(
            id: $clubEntity->getId(),
            externalId: $clubEntity->getExternalId(),
            name: $clubEntity->getName(),
            description: $clubEntity->getDescription(),
            sportTypes: \array_map(static fn(SportTypeEnum $sportType) => new ClubSportTypeCycleORMEntity(
                clubId: $clubEntity->getId(),
                type: $sportType->name,
            ), $clubEntity->getSportTypes()),
        );

        $this->entityManager->persist($this->toPersistenceClubEntityMapper->map(
            persistenceClubEntity: $persistenceClubEntity,
            domainClubEntity: $clubEntity,
        ));
        $this->entityManager->run();
    }

    public function update(ClubEntity $clubEntity): void
    {
        $this->entityManager->persist($this->toPersistenceClubEntityMapper->map(
            persistenceClubEntity: $this->get($clubEntity->getId()),
            domainClubEntity: $clubEntity,
        ));
        $this->entityManager->run();
    }

    public function getById(UuidInterface $id): ClubEntity
    {
        if (!$persistenceClubEntity = $this->get($id)) {
            throw new ClubNotFoundException();
        }
        return $this->toDomainClubEntityMapper->map($persistenceClubEntity);
    }

    public function getByCriteria(ClubCriteriaInterface $criteria): ClubCollection
    {
        $query = $this->select()->load(self::RELATIONS);

        if ($criteria->ids) {
            $query = $query->andWhere('id', 'IN', $criteria->ids);
        }
        if ($criteria->externalIds) {
            $query = $query->andWhere('external_id', 'IN', $criteria->externalIds);
        }
        if ($criteria->sportTypes) {
            $query = $query->andWhere('sportTypes.type', 'IN', \array_map(static fn(SportTypeEnum $sportType) => $sportType->name, $criteria->sportTypes));
        }
        if ($criteria->sorts) {
            foreach ($criteria->sorts as $sort) {
                /** @var SortCriteria $sort */
                $query->orderBy($sort->field, $sort->direction->name);
            }
        }

        $totalCountQuery = clone $query;
        if ($criteria->pagination) {
            $offset = ($criteria->pagination->page - 1) * $criteria->pagination->pageSize;
            $query->limit($criteria->pagination->pageSize)->offset($offset);
        }

        $data = \array_map(fn(ClubCycleORMEntity $clubEntity) => $this->toDomainClubEntityMapper->map(
            persistenceClubEntity: $clubEntity,
        ), $query->fetchAll());

        return new ClubCollection(
            data: $data,
            pagination: new PaginationVO(
                page: $criteria->pagination?->page ?? 1,
                pageSize: $criteria->pagination?->pageSize ?? \count($data),
                totalCount: $totalCountQuery->count(),
            ),
        );
    }

    private function get(UuidInterface $id): ?object
    {
        return $this->select()->wherePK($id)->load(self::RELATIONS)->fetchOne();
    }
}
