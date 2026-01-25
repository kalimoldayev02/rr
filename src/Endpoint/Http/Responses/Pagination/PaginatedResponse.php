<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Pagination;

use App\Endpoint\Http\Responses\JsonSerializableTrait;

final readonly class PaginatedResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        public array $data,
        public PaginationResponse $pagination,
    ) {}
}
