<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\RefreshToken;

use App\Domain\Exceptions\NotFoundException;

final class RefreshTokenNotFoundException extends NotFoundException
{
    public function __construct(string $message = "Refresh token not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
