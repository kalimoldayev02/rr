<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use Ramsey\Collection\AbstractCollection;

final class ClubCollection extends AbstractCollection
{
    public function getType(): string
    {
        return 'App\Domain\Entities\ClubEntity';
    }
}
