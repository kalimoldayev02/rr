<?php

declare(strict_types=1);

namespace App\Domain\Aggregates;

use App\Domain\Collections\ActivityLapCollection;
use App\Domain\Collections\ActivitySplitCollection;
use App\Domain\Entities\ActivityLapEntity;
use App\Domain\Entities\ActivitySplitEntity;
use App\Domain\Enums\SportTypeEnum;
use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use Ramsey\Uuid\UuidInterface;

final class ActivityAggregate
{
    private ActivityLapCollection $laps;
    private ActivitySplitCollection $splits;

    public function __construct(
        private readonly UuidInterface $id,
        private readonly int $externalId,
        private readonly UuidInterface $athleteId,
        private string $name,
        private DistanceVO $distance,
        private DurationVO $movingTime,
        private DurationVO $elapsedTime,
        private SportTypeEnum $sportType,
        private \DateTimeImmutable $startDate,
        private ?string $summaryPolyline,
    ) {
        $this->laps = new ActivityLapCollection();
        $this->splits = new ActivitySplitCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function getAthleteId(): UuidInterface
    {
        return $this->athleteId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDistance(): DistanceVO
    {
        return $this->distance;
    }

    public function setDistance(DistanceVO $distance): void
    {
        $this->distance = $distance;
    }

    public function getMovingTime(): DurationVO
    {
        return $this->movingTime;
    }

    public function setMovingTime(DurationVO $movingTime): void
    {
        $this->movingTime = $movingTime;
    }

    public function getElapsedTime(): DurationVO
    {
        return $this->elapsedTime;
    }

    public function setElapsedTime(DurationVO $elapsedTime): void
    {
        $this->elapsedTime = $elapsedTime;
    }

    public function getSportType(): SportTypeEnum
    {
        return $this->sportType;
    }

    public function setSportType(SportTypeEnum $sportType): void
    {
        $this->sportType = $sportType;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getSummaryPolyline(): ?string
    {
        return $this->summaryPolyline;
    }

    public function setSummaryPolyline(?string $summaryPolyline): void
    {
        $this->summaryPolyline = $summaryPolyline;
    }

    public function getLaps(): ActivityLapCollection
    {
        return $this->laps;
    }

    public function addLap(ActivityLapEntity $lapEntity): void
    {
        $this->laps->add($lapEntity);
    }

    public function setLaps(ActivityLapCollection $laps): void
    {
        $this->laps = $laps;
    }

    public function getSplits(): ActivitySplitCollection
    {
        return $this->splits;
    }

    public function addSplit(ActivitySplitEntity $splitEntity): void
    {
        $this->splits->add($splitEntity);
    }

    public function setSplits(ActivitySplitCollection $splits): void
    {
        $this->splits = $splits;
    }
}
