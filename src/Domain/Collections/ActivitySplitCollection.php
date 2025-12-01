<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Entities\ActivitySplitEntity;
use Ramsey\Collection\AbstractCollection;

final class ActivitySplitCollection extends AbstractCollection
{
    public function getType(): string
    {
        return ActivitySplitEntity::class;
    }
}
