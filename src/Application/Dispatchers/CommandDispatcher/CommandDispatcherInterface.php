<?php

declare(strict_types=1);

namespace App\Application\Dispatchers\CommandDispatcher;

interface CommandDispatcherInterface
{
    public function dispatch(object $command): void;
}
