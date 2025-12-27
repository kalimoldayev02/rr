<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'athlete_club_roles')]
#[Uuid7(field: 'id', nullable: false)]
#[Uuid7(field: 'userId', nullable: false)]
#[Uuid7(field: 'clubId', nullable: false)]
class AthleteClubRolesCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'uuid')]
        public UuidInterface $userId,
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

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function setUserId(UuidInterface $userId): void
    {
        $this->userId = $userId;
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
