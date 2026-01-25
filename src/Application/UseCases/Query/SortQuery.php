<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query;

use App\Application\Enums\Sort\SortDirectionEnum;

final readonly class SortQuery
{
    public function __construct(
        public string $field,
        public SortDirectionEnum $direction,
    ) {}
}
