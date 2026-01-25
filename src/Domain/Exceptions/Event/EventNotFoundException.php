<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Event;

use App\Domain\Exceptions\NotFoundException;

final class EventNotFoundException extends NotFoundException
{
    public function __construct(string $message = "Event not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
