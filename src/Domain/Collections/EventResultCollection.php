<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Entities\EventResultEntity;
use Ramsey\Collection\AbstractCollection;
use Ramsey\Uuid\UuidInterface;

final class EventResultCollection extends AbstractCollection
{
    public function getType(): string
    {
        return EventResultEntity::class;
    }

    public function getById(UuidInterface $id): ?EventResultEntity
    {
        foreach ($this->data as $eventResultEntity) {
            /** @var EventResultEntity $eventResultEntity */
            if ($eventResultEntity->getId()->equals($id)) {
                return $eventResultEntity;
            }
        }
        return null;
    }
}
