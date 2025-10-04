<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

interface ServiceConfiguratorInterface
{
    public function get(string $service, string $key): mixed;
}
