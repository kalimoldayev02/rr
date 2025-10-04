<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Collections\ClubCollection;
use App\Domain\Criteria\Club\ClubCriteriaInterface;
use App\Domain\Entities\ClubEntity;
use App\Domain\Exceptions\Club\ClubNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface ClubRepositoryInterface
{
    public function create(ClubEntity $clubEntity): void;

    public function update(ClubEntity $clubEntity): void;

    /**
     * @throws ClubNotFoundException
     */
    public function getById(UuidInterface $id): ClubEntity;

    public function getByCriteria(ClubCriteriaInterface $criteria): ClubCollection;
}
