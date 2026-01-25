<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Aggregates\EventAggregate;

final class EventCollection extends AbstractPaginatedCollection
{
    public function getType(): string
    {
        return EventAggregate::class;
    }
}
