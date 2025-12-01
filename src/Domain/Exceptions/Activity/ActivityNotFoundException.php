<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\Activity;

use App\Domain\Exceptions\NotFoundException;

final class ActivityNotFoundException extends NotFoundException
{
    public function __construct(string $message = "Activity not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
