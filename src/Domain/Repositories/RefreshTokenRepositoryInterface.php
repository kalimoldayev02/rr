<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Collections\RefreshTokenCollection;
use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Criteria\RefreshToken\RefreshTokenCriteriaInterface;

interface RefreshTokenRepositoryInterface
{
    public function create(RefreshTokenEntity $refreshTokenEntity): void;

    public function getByCriteria(RefreshTokenCriteriaInterface $criteria): RefreshTokenCollection;

    public function delete(RefreshTokenEntity $refreshTokenEntity): void;
}
