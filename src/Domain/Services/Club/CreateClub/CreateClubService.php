<?php

declare(strict_types=1);

namespace App\Domain\Services\Club\CreateClub;

use App\Domain\Entities\ClubEntity;
use App\Domain\Exceptions\Club\ClubExistsException;
use App\Domain\Repositories\ClubRepositoryInterface;
use App\Domain\Specifications\Cub\ClubExternalIdIsUniqueSpecification;
use App\Domain\ValueObjects\IdVO;

final readonly class CreateClubService
{
    public function __construct(
        private ClubRepositoryInterface $clubRepository,
        private ClubExternalIdIsUniqueSpecification $clubExternalIdIsUniqueSpecification,
    ) {}

    /**
     * @throws ClubExistsException
     */
    public function create(CreateClubDTO $club): void
    {
        if (!$this->clubExternalIdIsUniqueSpecification->isSatisfiedBy($club->externalId)) {
            throw new ClubExistsException();
        }

        $this->clubRepository->create(new ClubEntity(
            id: new IdVO($club->id)->getValue(),
            externalId: $club->externalId,
            name: $club->name,
            description: $club->description,
            sportTypes: $club->sportTypes,
        ));
    }
}
