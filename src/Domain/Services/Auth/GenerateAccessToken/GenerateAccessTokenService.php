<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\GenerateAccessToken;

use App\Domain\Entities\AccessTokenEntity;
use App\Domain\Repositories\AccessTokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class GenerateAccessTokenService
{
    public function __construct(
        private AccessTokenRepositoryInterface $accessTokenRepository,
    ) {}

    public function generate(UuidInterface $userId): AccessTokenEntity
    {
        return $this->accessTokenRepository->generate($userId);
    }
}
