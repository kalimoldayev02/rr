<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Collections\AthleteCollection;
use App\Domain\Criteria\Athlete\AthleteCriteriaInterface;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Exceptions\Athlete\AthleteNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface AthleteRepositoryInterface
{
    public function create(AthleteEntity $athleteEntity): void;

    public function update(AthleteEntity $athleteEntity): void;

    public function delete(AthleteEntity $athleteEntity): void;

    /**
     * @throws AthleteNotFoundException
     */
    public function getById(UuidInterface $id): AthleteEntity;

    public function getByCriteria(AthleteCriteriaInterface $criteria): AthleteCollection;
}
