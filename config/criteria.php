<?php

declare(strict_types=1);

use App\Domain\Criteria\Activity\ActivityQueryCriteria;
use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\Criteria\Club\ClubQueryCriteria;
use App\Domain\Criteria\Event\EventQueryCriteria;
use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceQueryCriteria;
use App\Domain\Criteria\RefreshToken\RefreshTokenQueryCriteria;
use App\Domain\Criteria\User\UserQueryCriteria;
use App\Infrastructure\Persistence\CycleORM\Mappers\Activity\ActivityQueryCriteriaToCycleSelectMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\AthleteQueryCriteriaToCycleSelectMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Club\ClubQueryCriteriaToCycleSelectMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Event\EventQueryCriteriaToCycleSelectMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Reference\DistanceReference\DistanceReferenceQueryCriteriaToCycleSelectMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\RefreshToken\RefreshTokenQueryCriteriaToCycleSelectMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\User\UserQueryCriteriaToCycleSelectMapper;

return [
    AthleteQueryCriteria::class => AthleteQueryCriteriaToCycleSelectMapper::class,
    ActivityQueryCriteria::class => ActivityQueryCriteriaToCycleSelectMapper::class,
    ClubQueryCriteria::class => ClubQueryCriteriaToCycleSelectMapper::class,
    UserQueryCriteria::class => UserQueryCriteriaToCycleSelectMapper::class,
    RefreshTokenQueryCriteria::class => RefreshTokenQueryCriteriaToCycleSelectMapper::class,
    DistanceReferenceQueryCriteria::class => DistanceReferenceQueryCriteriaToCycleSelectMapper::class,
    EventQueryCriteria::class => EventQueryCriteriaToCycleSelectMapper::class,
];
