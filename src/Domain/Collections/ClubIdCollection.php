<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use Ramsey\Collection\AbstractCollection;
use Ramsey\Uuid\UuidInterface;

final class ClubIdCollection extends AbstractCollection
{
    public function getType(): string
    {
        return UuidInterface::class;
    }
}
