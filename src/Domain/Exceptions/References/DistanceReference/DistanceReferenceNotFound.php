<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\References\DistanceReference;

use App\Domain\Exceptions\NotFoundException;

final class DistanceReferenceNotFound extends NotFoundException
{
    public function __construct(string $message = "Distance reference not found", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
