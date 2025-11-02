<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\Logout;

final readonly class LogoutCommand
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
