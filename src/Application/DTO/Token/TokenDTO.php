<?php

declare(strict_types=1);

namespace App\Application\DTO\Token;

final readonly class TokenDTO
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
