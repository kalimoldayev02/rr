<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Club;

use App\Domain\Criteria\Club\ClubQueryCriteria;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Enums\SportTypeEnum;
use Cycle\ORM\Select;

final readonly class ClubQueryCriteriaToCycleSelectMapper
{
    public function map(ClubQueryCriteria $criteria, Select $select): Select
    {
        if ($criteria->ids) {
            $select->andWhere('id', 'IN', $criteria->ids);
        }
        if ($criteria->externalIds) {
            $select->andWhere('external_id', 'IN', $criteria->externalIds);
        }
        if ($criteria->sportTypes) {
            $select->andWhere('sportTypes.type', 'IN', \array_map(static fn(SportTypeEnum $sportType) => $sportType->name, $criteria->sportTypes));
        }
        foreach ($criteria->sorts ?? [] as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }

        return $select;
    }
}
