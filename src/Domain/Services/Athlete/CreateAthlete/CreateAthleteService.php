<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\CreateAthlete;

use App\Domain\Entities\AthleteEntity;
use App\Domain\Exceptions\Athlete\AthleteExistsException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Specifications\Athlete\AthleteExternalIdIsUniqueSpecification;
use App\Domain\ValueObjects\IdVO;

final readonly class CreateAthleteService
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
        private AthleteExternalIdIsUniqueSpecification $athleteExternalIdIsUniqueSpecification,
    ) {}

    public function create(CreateAthleteDTO $athlete): void
    {
        if (!$this->athleteExternalIdIsUniqueSpecification->isSatisfiedBy($athlete->externalId)) {
            throw new AthleteExistsException();
        }

        $this->athleteRepository->create(new AthleteEntity(
            id: new IdVO($athlete->id),
            externalId: $athlete->externalId,
            firstname: $athlete->firstname,
            lastname: $athlete->lastname,
            gender: $athlete->gender,
        ));
    }
}
