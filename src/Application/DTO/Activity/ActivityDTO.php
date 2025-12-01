<?php

declare(strict_types=1);

namespace App\Application\DTO\Activity;

use App\Application\Enums\SportTypeEnum;
use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use Ramsey\Uuid\UuidInterface;

final readonly class ActivityDTO
{
    /**
     * @param UuidInterface $id
     * @param UuidInterface $athleteId
     * @param string $name
     * @param DistanceVO $distance
     * @param DurationVO $movingTime
     * @param DurationVO $elapsedTime
     * @param SportTypeEnum $sportType
     * @param \DateTimeImmutable $startDate
     * @param string|null $summaryPolyline
     * @param ActivitySplitDTO[] $splits
     * @param ActivityLapDTO[] $laps
     */
    public function __construct(
        public UuidInterface $id,
        public UuidInterface $athleteId,
        public string $name,
        public DistanceVO $distance,
        public DurationVO $movingTime,
        public DurationVO $elapsedTime,
        public SportTypeEnum $sportType,
        public \DateTimeImmutable $startDate,
        public ?string $summaryPolyline,
        public array $splits,
        public array $laps,
    ) {}
}
