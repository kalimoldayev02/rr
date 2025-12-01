<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses\Pagination;

use App\Endpoint\Http\Responses\JsonSerializableTrait;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final readonly class PaginationResponse implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        #[Property]
        public int $currentPage,
        #[Property]
        public int $limit,
        #[Property]
        public int $totalCount,
        #[Property]
        public int $totalPages,
    ) {}
}
