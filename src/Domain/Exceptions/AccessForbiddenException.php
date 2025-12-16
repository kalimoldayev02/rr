<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

final class AccessForbiddenException extends \DomainException
{
    public function __construct(string $message = "You don't have permission to perform this action", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
