<?php

declare(strict_types=1);

namespace App\Domain\Specifications\Cub;

use App\Domain\Criteria\Club\ClubQueryCriteria;
use App\Domain\Repositories\ClubRepositoryInterface;

final readonly class ClubExternalIdIsUniqueSpecification
{
    public function __construct(
        private ClubRepositoryInterface $clubRepository,
    ) {}

    public function isSatisfiedBy(string $externalId): bool
    {
        return $this->clubRepository->getByCriteria(new ClubQueryCriteria(
            externalIds: [$externalId],
        ))->isEmpty();
    }
}
