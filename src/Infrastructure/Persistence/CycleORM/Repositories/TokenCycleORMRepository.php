<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\TokenCollection;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Criteria\Token\TokenCriteriaInterface;
use App\Domain\Entities\TokenEntity;
use App\Domain\Repositories\TokenRepositoryInterface;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Persistence\CycleORM\Entities\TokenCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Token\DomainTokenEntityToPersistenceTokenEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Token\PersistenceTokenEntityToDomainTokenEntityMapper;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;
use Ramsey\Uuid\UuidInterface;

class TokenCycleORMRepository extends Repository implements TokenRepositoryInterface
{
    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly DomainTokenEntityToPersistenceTokenEntityMapper $toPersistenceTokenEntityMapper,
        private readonly PersistenceTokenEntityToDomainTokenEntityMapper $toDomainTokenEntityMapper,
    ) {
        parent::__construct($select);
    }

    public function create(TokenEntity $tokenEntity): void
    {
        $persistenceTokenEntity = new TokenCycleORMEntity(
            id: $tokenEntity->getId(),
            userId: $tokenEntity->getUserId(),
            token: $tokenEntity->getToken(),
            expiresAt: $tokenEntity->getExpiresAt(),
            type: $tokenEntity->getType()->name,
        );

        $this->entityManager->persist($this->toPersistenceTokenEntityMapper->map(
            persistenceTokenEntity: $persistenceTokenEntity,
            domainTokenEntity: $tokenEntity,
        ));
        $this->entityManager->run();
    }

    public function update(TokenEntity $tokenEntity): void
    {
        $this->entityManager->persist($this->toPersistenceTokenEntityMapper->map(
            persistenceTokenEntity: $this->get($tokenEntity->getId()),
            domainTokenEntity: $tokenEntity,
        ));
    }

    public function delete(TokenEntity $tokenEntity): void
    {
        $this->entityManager->delete($this->get($tokenEntity->getId()));
        $this->entityManager->run();
    }

    public function getByCriteria(TokenCriteriaInterface $criteria): TokenCollection
    {
        $query = $this->select();

        if ($criteria->userIds) {
            $query = $query->andWhere('user_id', 'IN', $criteria->userIds);
        }
        if ($criteria->toExpiresAt) {
            $query = $query->andWhere('expires_at', '<', $criteria->toExpiresAt);
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

        $data = \array_map(fn(TokenCycleORMEntity $tokenEntity) => $this->toDomainTokenEntityMapper->map(
            persistenceTokenEntity: $tokenEntity,
        ), $query->fetchAll());

        return new TokenCollection(
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
        return $this->select()->wherePK($id)->fetchOne();
    }
}
