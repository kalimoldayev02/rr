<?php

declare(strict_types=1);

namespace App\Application\Mappers\Pagination;

use App\Application\UseCases\Query\PaginationQuery;
use App\Domain\Criteria\PaginationCriteria;

final readonly class PaginationQueryToPaginationCriteriaMapper
{
    public function map(PaginationQuery $query): PaginationCriteria
    {
        return new PaginationCriteria(
            page: $query->page,
            pageSize: $query->pageSize,
        );
    }
}
