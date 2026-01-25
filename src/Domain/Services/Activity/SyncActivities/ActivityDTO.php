<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivities;

use App\Domain\Enums\SportTypeEnum;
use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;

final readonly class ActivityDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public DistanceVO $distance,
        public DurationVO $movingTime,
        public DurationVO $elapsedTime,
        public SportTypeEnum $sportType,
        public \DateTimeImmutable $startDate,
        public ?string $summaryPolyline,
    ) {}
}
