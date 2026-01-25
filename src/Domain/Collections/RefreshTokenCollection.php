<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Entities\RefreshTokenEntity;

final class RefreshTokenCollection extends AbstractPaginatedCollection
{
    public function getType(): string
    {
        return RefreshTokenEntity::class;
    }
}
