<?php

declare(strict_types=1);

namespace App\Application\DTO\Activity;

use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;

final readonly class ActivityLapDTO
{
    public function __construct(
        public string $name,
        public DistanceVO $distance,
        public DurationVO $movingTime,
        public DurationVO $elapsedTime,
        public int $lapIndex,
    ) {}
}
