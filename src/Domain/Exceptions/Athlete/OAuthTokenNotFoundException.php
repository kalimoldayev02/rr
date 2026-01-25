<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Athlete;

use App\Domain\Exceptions\NotFoundException;

final class OAuthTokenNotFoundException extends NotFoundException
{
    public function __construct(string $message = "OAth token not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
