<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Collections\TokenCollection;
use App\Domain\Criteria\Token\TokenQueryCriteria;
use App\Domain\Entities\TokenEntity;

interface TokenRepositoryInterface
{
    public function create(TokenEntity $tokenEntity): void;

    public function update(TokenEntity $tokenEntity): void;

    public function delete(TokenEntity $tokenEntity): void;

    public function getByCriteria(TokenQueryCriteria $criteria): TokenCollection;
}
