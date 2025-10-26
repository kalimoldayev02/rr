<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Repositories\OAuthTokenRepositoryInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\OAuthTokenCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\OAuthToken\DomainOAuthTokenEntityToPersistenceOAuthTokenEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\OAuthToken\PersistenceOAuthTokenEntityToDomainOAuthTokenEntityMapper;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;
use Ramsey\Uuid\UuidInterface;

final class OAuthTokenCycleORMRepository extends Repository implements OAuthTokenRepositoryInterface
{
    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly PersistenceOAuthTokenEntityToDomainOAuthTokenEntityMapper $toDomainMapper,
        private readonly DomainOAuthTokenEntityToPersistenceOAuthTokenEntityMapper $toPersistenceMapper,
    ) {
        parent::__construct($select);
    }

    public function create(OAuthTokenEntity $oauthToken): void
    {
        $persistenceOAuthTokenEntity = new OAuthTokenCycleORMEntity(
            id: $oauthToken->getId(),
            userId: $oauthToken->getUserId(),
            provider: $oauthToken->getProvider()->name,
            accessToken: $oauthToken->getAccessToken(),
            refreshToken: $oauthToken->getRefreshToken(),
            expiresAt: $oauthToken->getExpiresAt(),
        );

        $this->entityManager->persist($this->toPersistenceMapper->map(
            persistenceOAuthTokenEntity: $persistenceOAuthTokenEntity,
            domainOAuthTokenEntity: $oauthToken,
        ));
        $this->entityManager->run();
    }

    public function update(OAuthTokenEntity $oauthToken): void
    {
        $this->entityManager->persist($this->toPersistenceMapper->map(
            persistenceOAuthTokenEntity: $this->get($oauthToken->getId()),
            domainOAuthTokenEntity: $oauthToken,
        ));
        $this->entityManager->run();
    }

    private function get(UuidInterface $id): ?object
    {
        return $this->select()->wherePK($id)->fetchOne();
    }
}
