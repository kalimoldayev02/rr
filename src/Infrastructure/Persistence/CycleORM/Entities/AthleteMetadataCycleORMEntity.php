<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'athletes_metadata')]
#[Uuid7(field: 'userId', nullable: false)]
class AthleteMetadataCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'user_id', primary: true)]
        private UuidInterface $userId,
        #[Column(type: 'string', name: 'external_id')]
        private string $externalId,
    ) {}

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function setUserId(UuidInterface $userId): void
    {
        $this->userId = $userId;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }
}
