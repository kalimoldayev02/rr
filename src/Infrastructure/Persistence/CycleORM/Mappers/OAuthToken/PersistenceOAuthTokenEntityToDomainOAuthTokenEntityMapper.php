<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\OAuthToken;

use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Infrastructure\Persistence\CycleORM\Entities\OAuthTokenCycleORMEntity;

final readonly class PersistenceOAuthTokenEntityToDomainOAuthTokenEntityMapper
{
    public function map(OAuthTokenCycleORMEntity $persistenceEntity): OAuthTokenEntity
    {
        return new OAuthTokenEntity(
            id: $persistenceEntity->id,
            provider: match ($persistenceEntity->provider) {
                OAuthTokenProviderEnum::strava->name => OAuthTokenProviderEnum::strava,
            },
            accessToken: $persistenceEntity->accessToken,
            refreshToken: $persistenceEntity->refreshToken,
            expiresAt: $persistenceEntity->expiresAt,
        );
    }
}
