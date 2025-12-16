<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Event;

use App\Domain\Exceptions\NotFoundException;

final class EventResultNotFoundException extends NotFoundException
{
    public function __construct(string $message = "Event result not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
