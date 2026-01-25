<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'event_results')]
#[Uuid7(field: 'id', nullable: false)]
#[Uuid7(field: 'athleteId', nullable: false)]
#[Uuid7(field: 'distanceReferenceId', nullable: false)]
#[Uuid7(field: 'activityId', nullable: false)]
#[Uuid7(field: 'eventId', nullable: true)]
class EventResultCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'uuid', name: 'athlete_id')]
        private UuidInterface $athleteId,
        #[Column(type: 'uuid', name: 'activity_id', nullable: true)]
        private ?UuidInterface $activityId,
        #[Column(type: 'uuid', name: 'distance_reference_id')]
        private UuidInterface $distanceReferenceId,
        #[Column(type: 'float')]
        private float $duration,
        #[Column(type: 'string', name: 'duration_type')]
        private string $durationType,
        #[Column(type: 'uuid', name: 'event_id', nullable: true)]
        private ?UuidInterface $eventId = null,
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

    public function getDistanceReferenceId(): UuidInterface
    {
        return $this->distanceReferenceId;
    }

    public function setDistanceReferenceId(UuidInterface $distanceReferenceId): void
    {
        $this->distanceReferenceId = $distanceReferenceId;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): void
    {
        $this->duration = $duration;
    }

    public function getDurationType(): string
    {
        return $this->durationType;
    }

    public function setDurationType(string $durationType): void
    {
        $this->durationType = $durationType;
    }

    public function getEventId(): ?UuidInterface
    {
        return $this->eventId;
    }

    public function setEventId(?UuidInterface $eventId): void
    {
        $this->eventId = $eventId;
    }
}
