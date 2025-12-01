<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\User;

use App\Domain\Criteria\User\UserCriteriaInterface;
use Cycle\ORM\Select;

interface UserCriteriaMapperInterface
{
    public function getSelect(UserCriteriaInterface $criteria, Select $select): Select;
}
