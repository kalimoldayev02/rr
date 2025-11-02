<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use App\Endpoint\Http\Middlewares\ApiErrorHandlerMiddleware;
use Spiral\Bootloader\Http\RoutesBootloader as BaseRoutesBootloader;
use Spiral\Cookies\Middleware\CookiesMiddleware;
use Spiral\Csrf\Middleware\CsrfMiddleware;
use Spiral\Debug\StateCollector\HttpCollector;
use Spiral\Filter\ValidationHandlerMiddleware;
use Spiral\Http\Middleware\JsonPayloadMiddleware;
use Spiral\Router\Bootloader\AnnotatedRoutesBootloader;
use Spiral\Session\Middleware\SessionMiddleware;

final class RoutesBootloader extends BaseRoutesBootloader
{
    public function defineDependencies(): array
    {
        return [
            AnnotatedRoutesBootloader::class,
        ];
    }

    #[\Override]
    protected function globalMiddleware(): array
    {
        return [
            JsonPayloadMiddleware::class,
            HttpCollector::class,
            ApiErrorHandlerMiddleware::class,
        ];
    }

    #[\Override]
    protected function middlewareGroups(): array
    {
        return [
            'docs' => [],
            'web' => [
                CookiesMiddleware::class,
                SessionMiddleware::class,
                CsrfMiddleware::class,
                ValidationHandlerMiddleware::class,
            ],
            'api' => [
                ValidationHandlerMiddleware::class,
            ],
        ];
    }
}
