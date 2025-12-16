<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DurationVO;
use Ramsey\Uuid\UuidInterface;

final class EventResultEntity
{
    public function __construct(
        private UuidInterface $id,
        private UuidInterface $athleteId,
        private ?UuidInterface $activityId,
        private UuidInterface $distanceReferenceId,
        private DurationVO $duration,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getAthleteId(): UuidInterface
    {
        return $this->athleteId;
    }

    public function setAthleteId(UuidInterface $athleteId): void
    {
        $this->athleteId = $athleteId;
    }

    public function getActivityId(): ?UuidInterface
    {
        return $this->activityId;
    }

    public function setActivityId(?UuidInterface $activityId): void
    {
        $this->activityId = $activityId;
    }

    public function getDuration(): DurationVO
    {
        return $this->duration;
    }

    public function setDuration(DurationVO $duration): void
    {
        $this->duration = $duration;
    }

    public function getDistanceReferenceId(): UuidInterface
    {
        return $this->distanceReferenceId;
    }

    public function setDistanceReferenceId(UuidInterface $distanceReferenceId): void
    {
        $this->distanceReferenceId = $distanceReferenceId;
    }
}
