<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\RefreshToken;

use App\Domain\Entities\RefreshTokenEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\RefreshTokenCycleORMEntity;

final readonly class DomainRefreshTokenEntityToPersistenceRefreshTokenEntityMapper
{
    public function map(RefreshTokenCycleORMEntity $persistenceRefreshTokenEntity, RefreshTokenEntity $domainRefreshTokenEntity): RefreshTokenCycleORMEntity
    {
        $persistenceRefreshTokenEntity->setId($domainRefreshTokenEntity->getId());
        $persistenceRefreshTokenEntity->setToken($domainRefreshTokenEntity->getToken());
        $persistenceRefreshTokenEntity->setExpiresAt($domainRefreshTokenEntity->getExpiresAt());
        $persistenceRefreshTokenEntity->setUserId($domainRefreshTokenEntity->getUserId());
        if ($persistenceRefreshTokenEntity->getCreatedAt() === null) {
            $persistenceRefreshTokenEntity->setCreatedAt(new \DateTimeImmutable());
        }
        $persistenceRefreshTokenEntity->setUpdatedAt(new \DateTimeImmutable());

        return $persistenceRefreshTokenEntity;
    }
}
