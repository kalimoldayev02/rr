<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Event;

use App\Endpoint\Http\Responses\Activity\DistanceResponse;
use App\Endpoint\Http\Responses\Activity\DurationResponse;
use App\Endpoint\Http\Responses\Athlete\AthleteResponse;
use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\UuidInterface;

#[OA\Schema]
final readonly class EventResultResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $id,
        #[OA\Property(ref: AthleteResponse::class)]
        public AthleteResponse $athlete,
        #[OA\Property(type: 'string', format: 'uuid', nullable: true)]
        public ?UuidInterface $activityId,
        #[OA\Property(ref: DurationResponse::class)]
        public DurationResponse $duration,
        #[OA\Property(ref: DistanceResponse::class)]
        public DistanceResponse $distance,
    ) {}
}
