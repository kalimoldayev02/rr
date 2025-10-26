<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Entities\TokenEntity;
use App\Domain\Repositories\TokenRepositoryInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\TokenCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Token\DomainTokenEntityToPersistenceTokenEntityMapper;
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

    private function get(UuidInterface $id): ?object
    {
        return $this->select()->wherePK($id)->fetchOne();
    }
}
