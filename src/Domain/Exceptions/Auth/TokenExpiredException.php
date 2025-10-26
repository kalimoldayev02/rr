<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Auth;

final class TokenExpiredException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Token has expired');
    }
}