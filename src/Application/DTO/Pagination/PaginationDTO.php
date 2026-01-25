<?php

declare(strict_types=1);

namespace App\Application\DTO\Pagination;

final readonly class PaginationDTO
{
    public function __construct(
        public int $page,
        public int $pageSize,
        public int $totalCount,
    ) {}
}
