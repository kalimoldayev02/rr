<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Activity;

use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;

#[OA\Schema]
final readonly class ActivityLapResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property]
        public string $name,
        #[OA\Property(ref: DistanceResponse::class)]
        public DistanceResponse $distance,
        #[OA\Property(ref: DurationResponse::class)]
        public DurationResponse $movingTime,
        #[OA\Property(ref: DurationResponse::class)]
        public DurationResponse $elapsedTime,
        #[OA\Property]
        public int $lapIndex,
    ) {}
}
