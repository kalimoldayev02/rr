<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\GenerateRefreshToken;

use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Factories\RefreshToken\RefreshTokenFactory;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class GenerateRefreshTokenService
{
    public function __construct(
        private RefreshTokenFactory $refreshTokenFactory,
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
    ) {}

    public function generate(UuidInterface $userId): RefreshTokenEntity
    {
        $refreshTokenEntity = $this->refreshTokenFactory->create($userId);
        $this->refreshTokenRepository->create($refreshTokenEntity);

        return $refreshTokenEntity;
    }
}
