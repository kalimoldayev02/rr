<?php

declare(strict_types=1);

namespace App\Domain\Events\Athlete;

use Ramsey\Uuid\UuidInterface;

final readonly class AthleteRegisteredEvent
{
    public function __construct(
        public UuidInterface $athleteId,
    ) {}
}
