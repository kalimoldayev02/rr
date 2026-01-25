<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Pagination;

use Spiral\Filters\Attribute\Input\Query;

trait PaginationRequestTrait
{
    #[Query]
    private ?int $page = null;

    #[Query]
    private ?int $limit = null;

    public function getPage(): int
    {
        return $this->page ?? 1;
    }

    public function getLimit(): int
    {
        return $this->limit ?? 10;
    }
}
