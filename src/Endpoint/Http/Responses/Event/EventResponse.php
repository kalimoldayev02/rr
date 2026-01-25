<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Event;

use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\UuidInterface;

#[OA\Schema]
final readonly class EventResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $id,
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $clubId,
        #[OA\Property(type: 'string', format: 'date-time')]
        public string $date,
        #[OA\Property]
        public string $title,
    ) {}
}
