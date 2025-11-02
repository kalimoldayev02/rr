<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\RefreshToken;

use App\Domain\Entities\RefreshTokenEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\RefreshTokenCycleORMEntity;

final readonly class PersistenceTokenEntityToDomainTokenEntityMapper
{
    public function map(RefreshTokenCycleORMEntity $persistenceRefreshTokenEntity): RefreshTokenEntity
    {
        return new RefreshTokenEntity(
            id: $persistenceRefreshTokenEntity->getId(),
            userId: $persistenceRefreshTokenEntity->getUserId(),
            token: $persistenceRefreshTokenEntity->getToken(),
            expiresAt: $persistenceRefreshTokenEntity->getExpiresAt(),
        );
    }
}
