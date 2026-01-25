<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Sort;

use App\Domain\Criteria\SortCriteria;
use Cycle\ORM\Select;

final readonly class SortsCriteriaToCycleOrmSelect
{
    /**
     * @param SortCriteria[] $sorts
     */
    public function map(Select $select, array $sorts): Select
    {
        foreach ($sorts as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }
        return $select;
    }
}
