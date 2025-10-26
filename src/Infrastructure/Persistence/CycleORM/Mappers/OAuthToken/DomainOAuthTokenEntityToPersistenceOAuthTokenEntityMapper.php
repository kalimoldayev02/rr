<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\OAuthToken;

use App\Domain\Entities\OAuthTokenEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\OAuthTokenCycleORMEntity;

final readonly class DomainOAuthTokenEntityToPersistenceOAuthTokenEntityMapper
{
    public function map(OAuthTokenCycleORMEntity $persistenceOAuthTokenEntity, OAuthTokenEntity $domainOAuthTokenEntity): OAuthTokenCycleORMEntity
    {
        $persistenceOAuthTokenEntity->setId($domainOAuthTokenEntity->getId());
        $persistenceOAuthTokenEntity->setUserId($domainOAuthTokenEntity->getUserId());
        $persistenceOAuthTokenEntity->setProvider($domainOAuthTokenEntity->getProvider()->name);
        $persistenceOAuthTokenEntity->setAccessToken($domainOAuthTokenEntity->getAccessToken());
        $persistenceOAuthTokenEntity->setRefreshToken($domainOAuthTokenEntity->getRefreshToken());
        $persistenceOAuthTokenEntity->setExpiresAt($domainOAuthTokenEntity->getExpiresAt());

        return $persistenceOAuthTokenEntity;
    }
}