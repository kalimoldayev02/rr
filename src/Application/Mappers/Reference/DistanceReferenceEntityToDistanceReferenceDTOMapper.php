<?php

declare(strict_types=1);

namespace App\Application\Mappers\Reference;

use App\Application\DTO\Reference\DistanceReferenceDTO;
use App\Domain\Entities\DistanceReferenceEntity;

final readonly class DistanceReferenceEntityToDistanceReferenceDTOMapper
{
    public function map(DistanceReferenceEntity $distanceReferenceEntity): DistanceReferenceDTO
    {
        return new DistanceReferenceDTO(
            id: $distanceReferenceEntity->getId(),
            distance: $distanceReferenceEntity->getDistance(),
        );
    }
}
