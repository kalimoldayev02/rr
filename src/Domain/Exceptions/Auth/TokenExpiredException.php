<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Auth;

final class TokenExpiredException extends \DomainException
{
    public function __construct(string $message = "Token has expired", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
