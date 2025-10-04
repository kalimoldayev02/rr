<?php

declare(strict_types=1);

namespace App\Domain\Specifications\Athlete;

use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\Repositories\AthleteRepositoryInterface;

final readonly class AthleteExternalIdIsUniqueSpecification
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function isSatisfiedBy(int $externalId): bool
    {
        return $this->athleteRepository->getByCriteria(new AthleteQueryCriteria(
            externalIds: [$externalId],
        ))->count() === 0;
    }
}
