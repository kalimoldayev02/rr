<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Exceptions;

class HttpException extends \Exception
{
    public function __construct(string $message = "", int $code = 500, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
