<?php

declare(strict_types=1);

namespace App\Application\Mappers\Pagination;

use App\Application\DTO\Pagination\PaginationDTO;
use App\Domain\ValueObjects\PaginationVO;

final readonly class PaginationVOToPaginationDTOMapper
{
    public function map(PaginationVO $paginationVO): PaginationDTO
    {
        return new PaginationDTO(
            page: $paginationVO->page,
            pageSize: $paginationVO->pageSize,
            totalCount: $paginationVO->totalCount,
        );
    }
}
