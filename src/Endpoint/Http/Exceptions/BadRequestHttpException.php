<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Exceptions;

class BadRequestHttpException extends HttpException
{
    public function __construct(string $message = "", int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
