<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\ValueObjects\AthleteRoleVO;
use Ramsey\Collection\AbstractCollection;

final class AthleteRoleCollection extends AbstractCollection
{
    public function getType(): string
    {
        return AthleteRoleVO::class;
    }
}
