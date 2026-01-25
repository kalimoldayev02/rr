<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Exceptions\Athlete;

use App\Endpoint\Http\Exceptions\BadRequestHttpException;

final class AuthStateNotValidHttpException extends BadRequestHttpException
{
    public function __construct(string $message = "Invalid or expired authorization state", int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
