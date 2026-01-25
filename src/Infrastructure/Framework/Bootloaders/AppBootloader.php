<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use Spiral\Bootloader\DomainBootloader;
use Spiral\Cycle\Interceptor\CycleInterceptor;
use Spiral\DataGrid\Interceptor\GridInterceptor;
use Spiral\Domain\GuardInterceptor;
use Spiral\Interceptors\HandlerInterface;

final class AppBootloader extends DomainBootloader
{
    protected const SINGLETONS = [HandlerInterface::class => [self::class, 'domainCore']];

    protected const INTERCEPTORS = [
        CycleInterceptor::class,
        GridInterceptor::class,
        GuardInterceptor::class,
    ];
}
