<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'club_athletes')]
#[Uuid7(field: 'clubId', nullable: false)]
#[Uuid7(field: 'athleteId', nullable: false)]
class ClubAthleteCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'club_id', primary: true)]
        private UuidInterface $clubId,
        #[Column(type: 'uuid', name: 'athlete_id', primary: true)]
        private UuidInterface $athleteId,
    ) {}

    public function getClubId(): UuidInterface
    {
        return $this->clubId;
    }

    public function setClubId(UuidInterface $clubId): void
    {
        $this->clubId = $clubId;
    }

    public function getAthleteId(): UuidInterface
    {
        return $this->athleteId;
    }

    public function setAthleteId(UuidInterface $athleteId): void
    {
        $this->athleteId = $athleteId;
    }
}
