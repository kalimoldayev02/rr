<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\RefreshToken;

use App\Domain\Criteria\RefreshToken\RefreshTokenQueryCriteria;
use App\Domain\Criteria\SortCriteria;
use Cycle\ORM\Select;

final readonly class RefreshTokenQueryCriteriaToCycleSelectMapper
{
    public function map(RefreshTokenQueryCriteria $criteria, Select $select): Select
    {
        if ($criteria->userIds) {
            $select->andWhere('user_id', 'IN', $criteria->userIds);
        }
        if ($criteria->tokens) {
            $select->andWhere('token', 'IN', $criteria->tokens);
        }
        if ($criteria->toExpiresAt) {
            $select->andWhere('expires_at', '<=', $criteria->toExpiresAt);
        }
        foreach ($criteria->sorts ?? [] as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }

        return $select;
    }
}
