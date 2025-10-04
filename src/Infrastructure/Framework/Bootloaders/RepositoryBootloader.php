<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\AuthStateRepositoryInterface;
use App\Domain\Repositories\ClubRepositoryInterface;
use App\Infrastructure\Persistence\Cache\Repositories\AuthStateCacheRepository;
use App\Infrastructure\Persistence\CycleORM\Repositories\AthleteCycleORMRepository;
use App\Infrastructure\Persistence\CycleORM\Repositories\ClubCycleORMRepository;
use Spiral\Boot\Bootloader\Bootloader;

final class RepositoryBootloader extends Bootloader
{
    #[\Override]
    public function defineBindings(): array
    {
        return [
            AuthStateRepositoryInterface::class => AuthStateCacheRepository::class,
            AthleteRepositoryInterface::class => AthleteCycleORMRepository::class,
            ClubRepositoryInterface::class => ClubCycleORMRepository::class,
        ];
    }
}
