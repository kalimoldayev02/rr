<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Athlete;

final class AthleteExistsException extends \DomainException
{
    public function __construct(string $message = "Athlete exists", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
