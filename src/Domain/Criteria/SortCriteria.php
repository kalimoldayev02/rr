<?php

declare(strict_types=1);

namespace App\Domain\Criteria;

use App\Domain\Enums\SortDirectionEnum;

final readonly class SortCriteria
{
    public function __construct(
        public string $field,
        public SortDirectionEnum $direction,
    ) {}
}
