<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Pagination;

use App\Application\DTO\Pagination\PaginationDTO;
use App\Endpoint\Http\Responses\Pagination\PaginationResponse;

final readonly class PaginationDTOToPaginationResponseMapper
{
    public function map(PaginationDTO $pagination): PaginationResponse
    {
        return new PaginationResponse(
            currentPage: $pagination->page,
            limit: $pagination->pageSize,
            totalCount: $pagination->totalCount,
            totalPages: (int) \ceil($pagination->totalCount / $pagination->pageSize),
        );
    }
}
