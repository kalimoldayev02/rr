<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Auth;

final class InvalidCredentialsException extends \DomainException
{
    public function __construct(string $message = "Invalid email or password", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
