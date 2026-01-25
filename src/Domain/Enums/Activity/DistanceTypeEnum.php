<?php

declare(strict_types=1);

namespace App\Domain\Enums\Activity;

enum DistanceTypeEnum
{
    case meters;
    case kilometers;
    case miles;
}
