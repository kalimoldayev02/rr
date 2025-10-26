<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final readonly class PaginationVO
{
    public function __construct(
        public int $page,
        public int $pageSize,
        public int $totalCount,
    ) {}
}
