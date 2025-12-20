<?php

declare(strict_types=1);

namespace App\Application\DTO\Event;

use App\Application\DTO\Athlete\AthleteDTO;
use App\Application\DTO\Reference\DistanceReferenceDTO;
use App\Domain\ValueObjects\DurationVO;
use Ramsey\Uuid\UuidInterface;

final readonly class EventResultDTO
{
    public function __construct(
        public UuidInterface $id,
        public AthleteDTO $athlete,
        public UuidInterface $activityId,
        public DistanceReferenceDTO $distance,
        public DurationVO $duration,
    ) {}
}
