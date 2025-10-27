<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\RefreshToken;

final readonly class RefreshTokenCommand
{
    public function __construct(
        public string $refreshToken,
    ) {}
}
