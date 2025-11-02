<?php

declare(strict_types=1);

namespace App\Domain\Factories\RefreshToken;

use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\ValueObjects\IdVO;
use Ramsey\Uuid\UuidInterface;

final readonly class RefreshTokenFactory
{
    public function create(UuidInterface $userId): RefreshTokenEntity
    {
        return new RefreshTokenEntity(
            id: new IdVO()->getValue(),
            userId: $userId,
            token: \bin2hex(\random_bytes(32)),
            expiresAt: new \DateTimeImmutable()->modify('+30 days'),
        );
    }
}
