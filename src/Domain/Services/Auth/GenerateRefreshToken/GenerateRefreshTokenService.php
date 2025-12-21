<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\GenerateRefreshToken;

use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Domain\ValueObjects\IdVO;
use Ramsey\Uuid\UuidInterface;

final readonly class GenerateRefreshTokenService
{
    public function __construct(
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
    ) {}

    public function generate(UuidInterface $userId): RefreshTokenEntity
    {
        $refreshTokenEntity = new RefreshTokenEntity(
            id: new IdVO()->getValue(),
            userId: $userId,
            token: \bin2hex(\random_bytes(32)),
            expiresAt: new \DateTimeImmutable()->modify('+30 days'),
        );
        $this->refreshTokenRepository->create($refreshTokenEntity);

        return $refreshTokenEntity;
    }
}
