<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Activity;

use App\Endpoint\Http\Enums\SportTypeEnum;
use App\Endpoint\Http\Responses\JsonSerializableTrait;
use Ramsey\Uuid\UuidInterface;
use OpenApi\Attributes as OA;

#[OA\Schema]
final readonly class ActivityDetailResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $id,
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $athleteId,
        #[OA\Property]
        public string $name,
        #[OA\Property(ref: DistanceResponse::class)]
        public DistanceResponse $distance,
        #[OA\Property(ref: DurationResponse::class)]
        public DurationResponse $movingTime,
        #[OA\Property(ref: DurationResponse::class)]
        public DurationResponse $elapsedTime,
        #[OA\Property(enum: SportTypeEnum::class)]
        public SportTypeEnum $sportType,
        #[OA\Property(type: 'string', format: 'date-time', example: '2021-01-01T00:00:00+00:00')]
        public string $startDate,
        #[OA\Property(nullable: true, format: 'geo:json')]
        public ?string $summaryPolyline,
        #[OA\Property(type: 'array', items: new OA\Items(ref: ActivityLapResponse::class))]
        public array $laps,
        #[OA\Property(type: 'array', items: new OA\Items(ref: ActivitySplitResponse::class))]
        public array $splits,
    ) {}
}
