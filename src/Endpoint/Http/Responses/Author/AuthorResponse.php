<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Author;

use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\UuidInterface;

#[OA\Schema]
final readonly class AuthorResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @param UuidInterface[] $clubIds
     */
    public function __construct(
        #[OA\Property(type: 'string', format: 'uuid')]
        public UuidInterface $id,
        #[OA\Property]
        public string $firstName,
        #[OA\Property]
        public string $lastName,
        #[OA\Property(type: 'array', items: new OA\Items(type: 'string', format: 'uuid'))]
        public array $clubIds,
    ) {}
}
