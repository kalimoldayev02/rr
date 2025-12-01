<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Activity;

use App\Domain\Criteria\Activity\ActivityQueryCriteria;
use App\Domain\Criteria\SortCriteria;
use Cycle\ORM\Select;

final readonly class ActivityQueryCriteriaToCycleSelectMapper
{
    public function map(ActivityQueryCriteria $criteria, Select $select): Select
    {
        if ($criteria->athleteIds) {
            $select->where('athlete_id', 'IN', $criteria->athleteIds);
        }
        if ($criteria->fromDate) {
            $select->where('start_date', '>', $criteria->fromDate);
        }
        if ($criteria->toDate) {
            $select->where('start_date', '<', $criteria->toDate);
        }
        foreach ($criteria->sorts ?? [] as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }

        return $select;
    }
}
