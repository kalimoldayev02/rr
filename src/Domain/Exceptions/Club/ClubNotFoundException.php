<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Club;

use App\Domain\Exceptions\NotFoundException;

final class ClubNotFoundException extends NotFoundException
{
    public function __construct(string $message = "Club not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
