<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\Login;

final readonly class LoginOutputDTO
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
