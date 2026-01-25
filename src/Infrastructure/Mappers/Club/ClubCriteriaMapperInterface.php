<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Club;

use App\Domain\Criteria\Club\ClubCriteriaInterface;
use Cycle\ORM\Select;

interface ClubCriteriaMapperInterface
{
    public function getSelect(ClubCriteriaInterface $criteria, Select $select): Select;
}
