<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Event;

use App\Endpoint\Http\Responses\Author\AuthorResponse;
use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\UuidInterface;

#[OA\Schema]
final readonly class DetailEventResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @param EventResultResponse[] $results
     */
    public function __construct(
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $id,
        #[OA\Property(ref: AuthorResponse::class)]
        public AuthorResponse $author,
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $clubId,
        #[OA\Property(type: 'string', format: 'date-time')]
        public string $date,
        #[OA\Property]
        public string $title,
        #[OA\Property(items: new OA\Items(ref: EventResultResponse::class))]
        public array $results,
    ) {}
}
