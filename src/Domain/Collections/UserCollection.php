<?php

declare(strict_types=1);

namespace App\Domain\Collections;

final class UserCollection extends AbstractPaginatedCollection
{
    public function getType(): string
    {
        return 'App\Domain\Entities\UserEntity';
    }
}
