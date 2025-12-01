<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivityDetail;

use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;

final readonly class LapDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public DistanceVO $distance,
        public DurationVO $movingTime,
        public DurationVO $elapsedTime,
        public int $lapIndex,
    ) {}
}
