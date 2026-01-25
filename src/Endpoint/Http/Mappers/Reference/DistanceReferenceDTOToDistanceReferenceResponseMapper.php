<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Reference;

use App\Application\DTO\Reference\DistanceReferenceDTO;
use App\Endpoint\Http\Mappers\Activity\DistanceVOToDistanceResponseMapper;
use App\Endpoint\Http\Responses\Reference\DistanceReferenceResponse;

final readonly class DistanceReferenceDTOToDistanceReferenceResponseMapper
{
    public function __construct(
        private DistanceVOToDistanceResponseMapper $toDistanceResponseMapper,
    ) {}

    public function map(DistanceReferenceDTO $distanceReferenceDTO): DistanceReferenceResponse
    {
        return new DistanceReferenceResponse(
            id: $distanceReferenceDTO->id,
            distance: $this->toDistanceResponseMapper->map($distanceReferenceDTO->distance),
        );
    }
}
