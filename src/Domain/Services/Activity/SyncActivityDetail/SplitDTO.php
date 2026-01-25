<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivityDetail;

use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;

final readonly class SplitDTO
{
    public function __construct(
        public DistanceVO $distance,
        public DurationVO $movingTime,
        public DurationVO $elapsedTime,
        public int $split,
    ) {}
}
