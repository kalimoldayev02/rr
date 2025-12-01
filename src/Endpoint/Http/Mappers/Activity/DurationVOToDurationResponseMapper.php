<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Activity;

use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Domain\ValueObjects\DurationVO;
use App\Endpoint\Http\Responses\Activity\DurationResponse;
use App\Endpoint\Http\Enums\Activity\DurationTypeEnum as EndpointDurationTypeEnum;

final readonly class DurationVOToDurationResponseMapper
{
    public function map(DurationVO $duration): DurationResponse
    {
        return new DurationResponse(
            value: $duration->getValue(),
            type: match ($duration->getType()) {
                DurationTypeEnum::seconds => EndpointDurationTypeEnum::seconds,
                DurationTypeEnum::minutes => EndpointDurationTypeEnum::minutes,
            },
        );
    }
}
