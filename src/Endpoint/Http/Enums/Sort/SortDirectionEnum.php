<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Enums\Sort;

enum SortDirectionEnum: string
{
    case asc = 'asc';
    case desc = 'desc';
}
