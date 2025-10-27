<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Token;

use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;

#[OA\Schema]
final readonly class TokenResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property]
        public string $accessToken,
        #[OA\Property]
        public string $refreshToken,
    ) {}
}
