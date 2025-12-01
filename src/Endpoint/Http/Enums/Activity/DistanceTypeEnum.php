<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Enums\Activity;

enum DistanceTypeEnum: string
{
    case meters = 'meters';
    case kilometers = 'kilometers';
    case miles = 'miles';
}
