<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Athlete;

use App\Domain\Criteria\Athlete\AthleteCriteriaInterface;
use Cycle\ORM\Select;

interface AthleteCriteriaMapperInterface
{
    public function getSelect(AthleteCriteriaInterface $criteria, Select $select): Select;
}
