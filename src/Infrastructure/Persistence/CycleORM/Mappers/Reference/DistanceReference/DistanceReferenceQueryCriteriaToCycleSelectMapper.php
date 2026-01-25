<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Reference\DistanceReference;

use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceQueryCriteria;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use Cycle\ORM\Select;

final readonly class DistanceReferenceQueryCriteriaToCycleSelectMapper
{
    public function map(DistanceReferenceQueryCriteria $criteria, Select $select): Select
    {
        if ($criteria->ids) {
            $select->andWhere('id', 'IN', $criteria->ids);
        }

        if ($criteria->fromDistance !== null) {
            $select->andWhere('distance', '>=', $criteria->fromDistance);
        }

        if ($criteria->toDistance !== null) {
            $select->andWhere('distance', '<=', $criteria->toDistance);
        }

        if ($criteria->distanceTypes) {
            $select->andWhere('distance_type', 'IN', \array_map(
                static fn(DistanceTypeEnum $type) => $type->name,
                $criteria->distanceTypes,
            ));
        }

        foreach ($criteria->sorts ?? [] as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }

        return $select;
    }
}
