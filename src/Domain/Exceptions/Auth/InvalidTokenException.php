<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Auth;

final class InvalidTokenException extends \DomainException
{
    public function __construct(string $message = 'Invalid token')
    {
        parent::__construct($message);
    }
}