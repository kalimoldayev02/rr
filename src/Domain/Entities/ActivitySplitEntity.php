<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use Ramsey\Uuid\UuidInterface;

final class ActivitySplitEntity
{
    public function __construct(
        private UuidInterface $id,
        private DistanceVO $distance,
        private DurationVO $movingTime,
        private DurationVO $elapsedTime,
        private int $split,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
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

    public function getSplit(): int
    {
        return $this->split;
    }

    public function setSplit(int $split): void
    {
        $this->split = $split;
    }
}
