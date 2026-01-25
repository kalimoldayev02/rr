<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\Refresh;

final readonly class RefreshCommand
{
    public function __construct(
        public string $refreshToken,
    ) {}
}
