<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\User;

use App\Domain\Exceptions\NotFoundException;

final class UserNotFoundException extends NotFoundException
{
    public function __construct(string $message = "User not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
