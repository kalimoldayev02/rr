<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\RefreshToken;

use App\Domain\Criteria\RefreshToken\RefreshTokenCriteriaInterface;
use Cycle\ORM\Select;

interface RefreshTokenCriteriaMapperInterface
{
    public function getSelect(RefreshTokenCriteriaInterface $criteria, Select $select): Select;
}
