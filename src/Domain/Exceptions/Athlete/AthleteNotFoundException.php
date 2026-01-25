<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Athlete;

use App\Domain\Exceptions\NotFoundException;

final class AthleteNotFoundException extends NotFoundException
{
    public function __construct(string $message = "Athlete not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
