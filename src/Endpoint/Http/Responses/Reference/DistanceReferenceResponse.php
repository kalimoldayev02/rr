<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Reference;

use App\Endpoint\Http\Responses\Activity\DistanceResponse;
use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\UuidInterface;

#[OA\Schema]
final readonly class DistanceReferenceResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $id,
        #[OA\Property(ref: DistanceResponse::class)]
        public DistanceResponse $distance,
    ) {}
}
