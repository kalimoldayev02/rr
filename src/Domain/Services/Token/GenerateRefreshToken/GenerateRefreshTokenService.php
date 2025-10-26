<?php

declare(strict_types=1);

namespace App\Domain\Services\Token\GenerateRefreshToken;

use App\Domain\ValueObjects\TokenVO;

final readonly class GenerateRefreshTokenService
{
    public function generate(): TokenVO
    {
        return new TokenVO(
            token: \bin2hex(\random_bytes(32)),
            expiresAt: new \DateTimeImmutable()->modify('+30 days'),
        );
    }
}
