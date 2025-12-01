<?php

declare(strict_types=1);

namespace App\Application\Mappers\Sort;

use App\Application\Enums\Sort\SortDirectionEnum;
use App\Application\UseCases\Query\SortQuery;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Enums\Sort\SortDirectionEnum as DomainSortDirectionEnum;

final readonly class SortQueryToSortCriteriaMapper
{
    public function map(SortQuery $query): SortCriteria
    {
        return new SortCriteria(
            field: $query->field,
            direction: match ($query->direction) {
                SortDirectionEnum::desc => DomainSortDirectionEnum::desc,
                SortDirectionEnum::asc => DomainSortDirectionEnum::asc,
            },
        );
    }
}
