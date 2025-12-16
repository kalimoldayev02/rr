<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\UpdateEventResult;

use App\Domain\ValueObjects\DurationVO;
use Ramsey\Uuid\UuidInterface;

final readonly class UpdateEventResultCommand
{
    public function __construct(
        public UuidInterface $eventId,
        public UuidInterface $eventResultId,
        public UuidInterface $athleteId,
        public ?UuidInterface $activityId,
        public UuidInterface $distanceId,
        public DurationVO $duration,
    ) {}
}
