<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Enums\Activity;

enum DurationTypeEnum: string
{
    case minutes = 'minutes';
    case seconds = 'seconds';
}
