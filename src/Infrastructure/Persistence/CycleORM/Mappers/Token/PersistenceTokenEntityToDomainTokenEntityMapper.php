<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Token;

use App\Domain\Entities\TokenEntity;
use App\Domain\Enums\Token\TokenTypeEnum;
use App\Infrastructure\Persistence\CycleORM\Entities\TokenCycleORMEntity;

final readonly class PersistenceTokenEntityToDomainTokenEntityMapper
{
    public function map(TokenCycleORMEntity $persistenceTokenEntity): TokenEntity
    {
        return new TokenEntity(
            id: $persistenceTokenEntity->getId(),
            userId: $persistenceTokenEntity->getUserId(),
            token: $persistenceTokenEntity->getToken(),
            type: match ($persistenceTokenEntity->getType()) {
                TokenTypeEnum::refresh->name => TokenTypeEnum::refresh,
                TokenTypeEnum::access->name => TokenTypeEnum::access,
            },
            expiresAt: $persistenceTokenEntity->getExpiresAt(),
        );
    }
}
