<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Activity;

use App\Endpoint\Http\Responses\JsonSerializableTrait;
use App\Endpoint\Http\Enums\Activity\DurationTypeEnum;
use OpenApi\Attributes as OA;

#[OA\Schema]
final readonly class DurationResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property]
        public float $value,
        #[OA\Property(enum: DurationTypeEnum::class)]
        public DurationTypeEnum $type,
    ) {}
}
