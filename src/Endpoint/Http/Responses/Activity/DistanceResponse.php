<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Activity;

use App\Endpoint\Http\Enums\Activity\DistanceTypeEnum;
use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;

#[OA\Schema]
final readonly class DistanceResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property]
        public float $value,
        #[OA\Property(enum: DistanceTypeEnum::class)]
        public DistanceTypeEnum $type,
    ) {}
}
