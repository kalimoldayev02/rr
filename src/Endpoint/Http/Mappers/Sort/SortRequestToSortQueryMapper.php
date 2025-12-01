<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Sort;

use App\Application\UseCases\Query\SortQuery;
use App\Endpoint\Http\Enums\Sort\SortDirectionEnum;
use App\Endpoint\Http\Requests\Sort\SortRequest;
use App\Application\Enums\Sort\SortDirectionEnum as ApplicationSortDirectionEnum;

final readonly class SortRequestToSortQueryMapper
{
    public function map(SortRequest $request): SortQuery
    {
        return new SortQuery(
            field: $request->getField(),
            direction: match ($request->getDirection()) {
                SortDirectionEnum::asc => ApplicationSortDirectionEnum::asc,
                SortDirectionEnum::desc => ApplicationSortDirectionEnum::desc,
            },
        );
    }
}
