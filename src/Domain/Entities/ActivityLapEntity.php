<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use Ramsey\Uuid\UuidInterface;

final class ActivityLapEntity
{
    public function __construct(
        private UuidInterface $id,
        private int $externalId,
        private string $name,
        private DistanceVO $distance,
        private DurationVO $movingTime,
        private DurationVO $elapsedTime,
        private int $lapIndex,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
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

    public function getLapIndex(): int
    {
        return $this->lapIndex;
    }

    public function setLapIndex(int $lapIndex): void
    {
        $this->lapIndex = $lapIndex;
    }
}
