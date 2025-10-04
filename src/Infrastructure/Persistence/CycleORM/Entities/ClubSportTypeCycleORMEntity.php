<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'clubs_sport_types')]
#[Uuid7(field: 'clubId', nullable: false)]
class ClubSportTypeCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'club_id', primary: true)]
        private UuidInterface $clubId,
        #[Column(type: 'string')]
        private string $type,
    ) {}

    public function getClubId(): UuidInterface
    {
        return $this->clubId;
    }

    public function setClubId(UuidInterface $clubId): void
    {
        $this->clubId = $clubId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
