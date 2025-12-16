<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Reference\DistanceReference;

use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceCriteriaInterface;
use Cycle\ORM\Select;

interface DistanceReferenceCriteriaMapperInterface
{
    public function getSelect(DistanceReferenceCriteriaInterface $criteria, Select $select): Select;
}
