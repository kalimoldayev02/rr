<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Event;

use App\Domain\Criteria\Event\EventCriteriaInterface;
use Cycle\ORM\Select;

interface EventCriteriaMapperInterface
{
    public function getSelect(EventCriteriaInterface $criteria, Select $select): Select;
}
