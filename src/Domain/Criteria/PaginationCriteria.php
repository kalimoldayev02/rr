<?php

declare(strict_types=1);

namespace App\Domain\Criteria;

final readonly class PaginationCriteria
{
    public function __construct(
        public int $page = 1,
        public int $pageSize = 10,
    ) {}
}
