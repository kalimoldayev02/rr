<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Exceptions;

use App\Application\Exceptions\ApplicationException;
use App\Domain\Exceptions\Auth\InvalidCredentialsException;
use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Exceptions\NotFoundException;
use Spiral\Exceptions\ExceptionHandler;
use Spiral\Http\Exception\ClientException;
use Spiral\Router\Exception\RouteNotFoundException;

final class Handler extends ExceptionHandler
{
    public function getHttpStatusCode(\Throwable $exception): int
    {
        return match (true) {
            $exception instanceof NotFoundException, $exception instanceof RouteNotFoundException => 404,

            $exception instanceof InvalidCredentialsException, $exception instanceof InvalidTokenException => 401,

            $exception instanceof ApplicationException => 400,

            $exception instanceof ClientException => $exception->getCode(),

            default => 500,
        };
    }

    #[\Override]
    protected function bootBasicHandlers(): void
    {
        parent::bootBasicHandlers();
    }
}
