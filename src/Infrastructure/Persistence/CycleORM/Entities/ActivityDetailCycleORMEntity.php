<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'activity_details')]
#[Uuid7(field: 'activityId', nullable: false)]
class ActivityDetailCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'activity_id', primary: true)]
        private UuidInterface $activityId,
        #[Column(type: 'json', nullable: true, typecast: 'json')]
        private array $laps,
        #[Column(type: 'json', nullable: true, typecast: 'json')]
        private array $splits,
    ) {}

    public function getActivityId(): UuidInterface
    {
        return $this->activityId;
    }

    public function setActivityId(UuidInterface $activityId): void
    {
        $this->activityId = $activityId;
    }

    public function getLaps(): array
    {
        return $this->laps;
    }

    public function setLaps(array $laps): void
    {
        $this->laps = $laps;
    }

    public function getSplits(): array
    {
        return $this->splits;
    }

    public function setSplits(array $splits): void
    {
        $this->splits = $splits;
    }
}
