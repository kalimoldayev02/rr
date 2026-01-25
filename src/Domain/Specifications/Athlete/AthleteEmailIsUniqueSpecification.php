<?php

declare(strict_types=1);

namespace App\Domain\Specifications\Athlete;

use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\ValueObjects\EmailVO;

final readonly class AthleteEmailIsUniqueSpecification
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function isSatisfiedBy(EmailVO $email): bool
    {
        return $this->athleteRepository->getByCriteria(new AthleteQueryCriteria(
            emails: [$email],
        ))->isEmpty();
    }
}
