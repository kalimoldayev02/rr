<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Reference\DistanceReference\GetDistanceReferences;

use App\Application\DTO\Pagination\PaginatedDataDTO;
use App\Application\Mappers\Pagination\PaginationVOToPaginationDTOMapper;
use App\Application\Mappers\Reference\DistanceReferenceEntityToDistanceReferenceDTOMapper;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;

final readonly class GetDistanceReferencesQueryHandler
{
    public function __construct(
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
        private GetDistanceReferencesQueryToDistanceReferenceCriteriaMapper $toDistanceReferenceCriteriaMapper,
        private DistanceReferenceEntityToDistanceReferenceDTOMapper $toDistanceReferenceDTOMapper,
        private PaginationVOToPaginationDTOMapper $toPaginationDTOMapper,
    ) {}

    public function handle(GetDistanceReferencesQuery $query): PaginatedDataDTO
    {
        $distanceReferenceCollection = $this->distanceReferenceRepository->getByCriteria(
            $this->toDistanceReferenceCriteriaMapper->map($query),
        );

        return new PaginatedDataDTO(
            data: \array_map(
                fn(DistanceReferenceEntity $distanceReferenceEntity) => $this->toDistanceReferenceDTOMapper->map($distanceReferenceEntity),
                $distanceReferenceCollection->toArray(),
            ),
            pagination: $this->toPaginationDTOMapper->map($distanceReferenceCollection->getPagination()),
        );
    }
}
