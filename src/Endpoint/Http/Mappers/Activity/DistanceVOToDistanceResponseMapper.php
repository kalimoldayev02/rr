<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Activity;

use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\ValueObjects\DistanceVO;
use App\Endpoint\Http\Responses\Activity\DistanceResponse;
use App\Endpoint\Http\Enums\Activity\DistanceTypeEnum as EndpointDistanceTypeEnum;

final readonly class DistanceVOToDistanceResponseMapper
{
    public function map(DistanceVO $distance): DistanceResponse
    {
        return new DistanceResponse(
            value: $distance->getValue(),
            type: match ($distance->getType()) {
                DistanceTypeEnum::meters => EndpointDistanceTypeEnum::meters,
                DistanceTypeEnum::kilometers => EndpointDistanceTypeEnum::kilometers,
                DistanceTypeEnum::miles => EndpointDistanceTypeEnum::miles,
            },
        );
    }
}
