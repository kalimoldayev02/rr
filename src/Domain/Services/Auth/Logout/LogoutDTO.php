<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\Logout;

final readonly class LogoutDTO
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
