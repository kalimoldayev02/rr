<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Entities\ActivityLapEntity;
use Ramsey\Collection\AbstractCollection;

final class ActivityLapCollection extends AbstractCollection
{
    public function getType(): string
    {
        return ActivityLapEntity::class;
    }
}
