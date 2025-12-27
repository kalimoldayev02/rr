<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'user_club_roles')]
#[Uuid7(field: 'id', nullable: false)]
#[Uuid7(field: 'athleteId', nullable: false)]
#[Uuid7(field: 'clubId', nullable: false)]
#[Uuid7(field: 'roleId', nullable: false)]
class AthleteClubRolesCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'uuid', name: 'athlete_id')]
        public UuidInterface $athleteId,
        #[Column(type: 'uuid')]
        public UuidInterface $clubId,
        #[Column(type: 'uuid')]
        public UuidInterface $roleId,
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

    public function getClubId(): UuidInterface
    {
        return $this->clubId;
    }

    public function setClubId(UuidInterface $clubId): void
    {
        $this->clubId = $clubId;
    }

    public function getRoleId(): UuidInterface
    {
        return $this->roleId;
    }

    public function setRoleId(UuidInterface $roleId): void
    {
        $this->roleId = $roleId;
    }
}
