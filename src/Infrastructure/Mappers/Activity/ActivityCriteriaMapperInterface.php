<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Activity;

use App\Domain\Criteria\Activity\ActivityCriteriaInterface;
use Cycle\ORM\Select;

interface ActivityCriteriaMapperInterface
{
    /**
     * @throws \UnexpectedValueException
     */
    public function getSelect(ActivityCriteriaInterface $criteria, Select $select): Select;
}
