<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'athlete_metadata')]
#[Uuid7(field: 'userId', nullable: false)]
class AthleteMetadataCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'user_id', primary: true)]
        private UuidInterface $userId,
        #[Column(type: 'bigInteger', name: 'external_id')]
        private int $externalId,
    ) {}

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function setUserId(UuidInterface $userId): void
    {
        $this->userId = $userId;
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
