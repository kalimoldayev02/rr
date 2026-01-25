<?php

declare(strict_types=1);

namespace App\Application\DTO\Pagination;

final readonly class PaginatedDataDTO
{
    public function __construct(
        public array $data,
        public PaginationDTO $pagination,
    ) {}
}
