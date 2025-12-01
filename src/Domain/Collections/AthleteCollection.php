<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Entities\AthleteEntity;

final class AthleteCollection extends AbstractPaginatedCollection
{
    public function getType(): string
    {
        return AthleteEntity::class;
    }
}
