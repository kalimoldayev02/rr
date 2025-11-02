<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use App\Domain\Repositories\AccessTokenRepositoryInterface;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\AuthStateRepositoryInterface;
use App\Domain\Repositories\ClubRepositoryInterface;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Cache\Repositories\AccessTokenCacheRepository;
use App\Infrastructure\Persistence\Cache\Repositories\AuthStateCacheRepository;
use App\Infrastructure\Persistence\CycleORM\Repositories\AthleteCycleORMRepository;
use App\Infrastructure\Persistence\CycleORM\Repositories\ClubCycleORMRepository;
use App\Infrastructure\Persistence\CycleORM\Repositories\RefreshTokenCycleORMRepository;
use App\Infrastructure\Persistence\CycleORM\Repositories\UserCycleORMRepository;
use Spiral\Boot\Bootloader\Bootloader;

final class RepositoryBootloader extends Bootloader
{
    #[\Override]
    public function defineBindings(): array
    {
        return [
            AuthStateRepositoryInterface::class => AuthStateCacheRepository::class,
            AthleteRepositoryInterface::class => AthleteCycleORMRepository::class,
            RefreshTokenRepositoryInterface::class => RefreshTokenCycleORMRepository::class,
            UserRepositoryInterface::class => UserCycleORMRepository::class,
            AccessTokenRepositoryInterface::class => AccessTokenCacheRepository::class,
            ClubRepositoryInterface::class => ClubCycleORMRepository::class,
        ];
    }
}
