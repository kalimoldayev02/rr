<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'athlete_metadata')]
#[Uuid7(field: 'athleteId', nullable: false)]
class AthleteMetadataCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'user_id', primary: true)]
        private UuidInterface $athleteId,
        #[Column(type: 'bigInteger', name: 'external_id')]
        private int $externalId,
    ) {}

    public function getAthleteId(): UuidInterface
    {
        return $this->athleteId;
    }

    public function setAthleteId(UuidInterface $athleteId): void
    {
        $this->athleteId = $athleteId;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }
}
