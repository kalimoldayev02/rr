<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use App\Infrastructure\Mappers\Activity\ActivityCriteriaMapper;
use App\Infrastructure\Mappers\Activity\ActivityCriteriaMapperInterface;
use App\Infrastructure\Mappers\Athlete\AthleteCriteriaMapper;
use App\Infrastructure\Mappers\Athlete\AthleteCriteriaMapperInterface;
use App\Infrastructure\Mappers\Club\ClubCriteriaMapper;
use App\Infrastructure\Mappers\Club\ClubCriteriaMapperInterface;
use App\Infrastructure\Mappers\Reference\DistanceReference\DistanceReferenceCriteriaMapper;
use App\Infrastructure\Mappers\Reference\DistanceReference\DistanceReferenceCriteriaMapperInterface;
use App\Infrastructure\Mappers\RefreshToken\RefreshTokenCriteriaMapper;
use App\Infrastructure\Mappers\RefreshToken\RefreshTokenCriteriaMapperInterface;
use App\Infrastructure\Mappers\User\UserCriteriaMapper;
use App\Infrastructure\Mappers\User\UserCriteriaMapperInterface;
use Spiral\Boot\Bootloader\Bootloader;

final class CriteriaBootloader extends Bootloader
{
    #[\Override]
    public function defineSingletons(): array
    {
        return [
            AthleteCriteriaMapperInterface::class => AthleteCriteriaMapper::class,
            ActivityCriteriaMapperInterface::class => ActivityCriteriaMapper::class,
            ClubCriteriaMapperInterface::class => ClubCriteriaMapper::class,
            UserCriteriaMapperInterface::class => UserCriteriaMapper::class,
            RefreshTokenCriteriaMapperInterface::class => RefreshTokenCriteriaMapper::class,
            DistanceReferenceCriteriaMapperInterface::class => DistanceReferenceCriteriaMapper::class,
        ];
    }
}
