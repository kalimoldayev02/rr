<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Activity\SyncActivities;

use Ramsey\Uuid\UuidInterface;

final readonly class SyncActivitiesCommand
{
    public function __construct(
        public UuidInterface $athleteId,
    ) {}
}
