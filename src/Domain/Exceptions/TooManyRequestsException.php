<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class TooManyRequestsException extends \DomainException
{
    public function __construct(string $message = "Too many requests", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
