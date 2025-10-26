<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Token;

use App\Domain\Entities\TokenEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\TokenCycleORMEntity;

final readonly class DomainTokenEntityToPersistenceTokenEntityMapper
{
    public function map(TokenCycleORMEntity $persistenceTokenEntity, TokenEntity $domainTokenEntity): TokenCycleORMEntity
    {
        $persistenceTokenEntity->setId($domainTokenEntity->getId());
        $persistenceTokenEntity->setToken($domainTokenEntity->getToken());
        $persistenceTokenEntity->setExpiresAt($domainTokenEntity->getExpiresAt());
        $persistenceTokenEntity->setType($domainTokenEntity->getType()->name);
        $persistenceTokenEntity->setUserId($domainTokenEntity->getUserId());

        return $persistenceTokenEntity;
    }
}
