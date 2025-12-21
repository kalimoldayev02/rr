<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Auth;

use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes as OA;

#[OA\Schema]
final readonly class GetRegisterUrlResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[OA\Property]
        public string $url,
    ) {}
}
