<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Event;

use App\Domain\Criteria\Event\EventQueryCriteria;
use App\Domain\Criteria\SortCriteria;
use Cycle\ORM\Select;

final readonly class EventQueryCriteriaToCycleSelectMapper
{
    public function map(EventQueryCriteria $criteria, Select $select): Select
    {
        if ($criteria->ids) {
            $select->andWhere('id', 'IN', $criteria->ids);
        }

        if ($criteria->clubIds) {
            $select->andWhere('club_id', 'IN', $criteria->clubIds);
        }

        if ($criteria->athleteIds) {
            $select->with('results', ['method' => Select\JoinableLoader::LEFT_JOIN])
                ->andWhere('results.athlete_id', 'IN', $criteria->athleteIds);
        }

        if ($criteria->authorIds) {
            $select->andWhere('author_id', 'IN', $criteria->authorIds);
        }

        if ($criteria->fromDate !== null) {
            $select->andWhere('date', '>=', $criteria->fromDate);
        }

        if ($criteria->toDate !== null) {
            $select->andWhere('date', '<=', $criteria->toDate);
        }

        if ($criteria->title !== null) {
            $select->andWhere('title', 'LIKE', '%' . $criteria->title . '%');
        }

        foreach ($criteria->sorts ?? [] as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }

        return $select;
    }
}
