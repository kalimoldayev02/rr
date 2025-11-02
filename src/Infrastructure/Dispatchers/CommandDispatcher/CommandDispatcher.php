<?php

declare(strict_types=1);

namespace App\Infrastructure\Dispatchers\CommandDispatcher;

use App\Application\Dispatchers\CommandDispatcher\CommandDispatcherInterface;
use Psr\Container\ContainerInterface;

final readonly class CommandDispatcher implements CommandDispatcherInterface
{
    public function __construct(
        private ContainerInterface $container,
        private CommandDispatcherConfiguration $configurator,
    ) {}

    public function dispatch(object $command): void
    {
        if ($this->configurator->get($command::class, 'queue')) {
            // TODO
        } else {
            $handler = $this->container->get($this->configurator->get($command::class, 'handler'));
            $handler->handle($command);
        }
    }
}
