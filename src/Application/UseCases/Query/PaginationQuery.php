<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query;

final readonly class PaginationQuery
{
    public function __construct(
        public int $page = 1,
        public int $pageSize = 10,
    ) {}
}
