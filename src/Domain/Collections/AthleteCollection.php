<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use Ramsey\Collection\AbstractCollection;

final class AthleteCollection extends AbstractCollection
{
    public function getType(): string
    {
        return 'App\Domain\Entities\AthleteEntity';
    }
}
