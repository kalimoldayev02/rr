<?php

declare(strict_types=1);

namespace App\Domain\Collections;

final class AthleteIdCollection extends AbstractPaginatedCollection
{
    public function getType(): string
    {
        return 'Ramsey\Uuid\UuidInterface';
    }
}
