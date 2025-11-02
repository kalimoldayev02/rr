<?php

declare(strict_types=1);

namespace App\Domain\DTO\Token;

use App\Domain\Entities\AccessTokenEntity;
use App\Domain\Entities\RefreshTokenEntity;

final readonly class TokenDTO
{
    public function __construct(
        public AccessTokenEntity $accessTokenEntity,
        public RefreshTokenEntity $refreshTokenEntity,
    ) {}
}
