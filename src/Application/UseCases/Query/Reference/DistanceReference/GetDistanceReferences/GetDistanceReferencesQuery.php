<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Reference\DistanceReference\GetDistanceReferences;

use App\Application\UseCases\Query\PaginationQuery;
use App\Application\UseCases\Query\SortQuery;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class GetDistanceReferencesQuery
{
    /**
     * @param UuidInterface[]|null $ids
     * @param DistanceTypeEnum[]|null $distanceTypes
     * @param SortQuery[]|null $sorts
     */
    public function __construct(
        public ?array $ids = null,
        public ?float $fromDistance = null,
        public ?float $toDistance = null,
        public ?array $distanceTypes = null,
        public ?array $sorts = null,
        public ?PaginationQuery $pagination = null,
    ) {}
}
