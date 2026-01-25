<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\RefreshTokenCollection;
use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Exceptions\RefreshToken\RefreshTokenNotFoundException;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Mappers\RefreshToken\RefreshTokenCriteriaMapperInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\RefreshTokenCycleORMEntity;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;
use App\Infrastructure\Persistence\CycleORM\Mappers\RefreshToken\DomainRefreshTokenEntityToPersistenceRefreshTokenEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\RefreshToken\PersistenceTokenEntityToDomainTokenEntityMapper;
use Ramsey\Uuid\UuidInterface;
use App\Domain\Criteria\RefreshToken\RefreshTokenCriteriaInterface;

class RefreshTokenCycleORMRepository extends Repository implements RefreshTokenRepositoryInterface
{
    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly RefreshTokenCriteriaMapperInterface $criteriaMapper,
        private readonly DomainRefreshTokenEntityToPersistenceRefreshTokenEntityMapper $toPersistenceRefreshTokenEntityMapper,
        private readonly PersistenceTokenEntityToDomainTokenEntityMapper $toDomainRefreshTokenEntityMapper,
    ) {
        parent::__construct($select);
    }

    public function create(RefreshTokenEntity $refreshTokenEntity): void
    {
        $persistenceTokenEntity = new RefreshTokenCycleORMEntity(
            id: $refreshTokenEntity->getId(),
            athleteId: $refreshTokenEntity->getAthleteId(),
            token: $refreshTokenEntity->getToken(),
            expiresAt: $refreshTokenEntity->getExpiresAt(),
        );

        $this->entityManager->persist($this->toPersistenceRefreshTokenEntityMapper->map(
            persistenceRefreshTokenEntity: $persistenceTokenEntity,
            domainRefreshTokenEntity: $refreshTokenEntity,
        ));
        $this->entityManager->run();
    }

    public function delete(RefreshTokenEntity $refreshTokenEntity): void
    {
        $this->entityManager->delete($this->get($refreshTokenEntity->getId()));
        $this->entityManager->run();
    }

    public function getByCriteria(RefreshTokenCriteriaInterface $criteria): RefreshTokenCollection
    {
        $select = $this->criteriaMapper->getSelect($criteria, $this->select());

        $totalCountQuery = clone $select;
        if ($criteria->pagination) {
            $offset = ($criteria->pagination->page - 1) * $criteria->pagination->pageSize;
            $select->limit($criteria->pagination->pageSize)->offset($offset);
        }

        $data = $select->fetchAll();

        return new RefreshTokenCollection(
            data: \array_map(fn(RefreshTokenCycleORMEntity $refreshTokenEntity) => $this->toDomainRefreshTokenEntityMapper->map(
                persistenceRefreshTokenEntity: $refreshTokenEntity,
            ), $data),
            pagination: new PaginationVO(
                page: $criteria->pagination?->page ?? 1,
                pageSize: $criteria->pagination?->pageSize ?? \count($data),
                totalCount: $totalCountQuery->count(),
            ),
        );
    }

    private function get(UuidInterface $id): object
    {
        if (!$data = $this->select()->wherePK($id)->fetchOne()) {
            throw new RefreshTokenNotFoundException();
        }
        return $data;
    }
}
