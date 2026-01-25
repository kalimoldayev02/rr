<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Auth;

final class AuthStateNotValidException extends \DomainException
{
    public function __construct(string $message = "Authorization state is invalid or expired", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
