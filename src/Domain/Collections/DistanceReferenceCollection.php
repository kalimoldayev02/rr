<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Entities\DistanceReferenceEntity;

final class DistanceReferenceCollection extends AbstractPaginatedCollection
{
    public function getType(): string
    {
        return DistanceReferenceEntity::class;
    }
}
