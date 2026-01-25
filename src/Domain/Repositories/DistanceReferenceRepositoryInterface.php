<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Collections\DistanceReferenceCollection;
use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceCriteriaInterface;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Exceptions\References\DistanceReference\DistanceReferenceNotFound;
use Ramsey\Uuid\UuidInterface;

interface DistanceReferenceRepositoryInterface
{
    public function create(DistanceReferenceEntity $distanceReferenceEntity): void;

    /**
     * @throws DistanceReferenceNotFound
     */
    public function update(DistanceReferenceEntity $eventDistanceReferenceEntity): void;

    /**
     * @throws DistanceReferenceNotFound
     */
    public function delete(DistanceReferenceEntity $eventDistanceReferenceEntity): void;

    /**
     * @throws DistanceReferenceNotFound
     */
    public function getById(UuidInterface $id): DistanceReferenceEntity;

    public function getByCriteria(DistanceReferenceCriteriaInterface $criteria): DistanceReferenceCollection;
}
