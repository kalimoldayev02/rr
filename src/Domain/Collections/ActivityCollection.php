<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Aggregates\ActivityAggregate;

final class ActivityCollection extends AbstractPaginatedCollection
{
    public function getType(): string
    {
        return ActivityAggregate::class;
    }
}
