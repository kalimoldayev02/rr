<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Athlete\SyncAthleteWithClubs;

use Ramsey\Uuid\UuidInterface;

final readonly class SyncAthleteWithClubsCommand
{
    public function __construct(
        public UuidInterface $athleteId,
    ) {}
}
