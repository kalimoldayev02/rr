<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Reference\DistanceReference;

use App\Domain\Enums\Activity\DistanceTypeEnum as DomainDistanceTypeEnum;
use App\Endpoint\Http\Enums\Activity\DistanceTypeEnum;
use App\Endpoint\Http\Requests\Pagination\PaginationRequestTrait;
use App\Endpoint\Http\Requests\Sort\SortRequestTrait;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validation\Laravel\FilterDefinition;

#[OA\Schema]
final class GetDistanceReferencesRequest extends Filter implements HasFilterDefinition
{
    use PaginationRequestTrait;
    use SortRequestTrait;

    #[Query]
    #[OA\Property(type: 'array', items: new OA\Items(type: 'string', format: 'uuid'), nullable: true)]
    private ?array $ids = null;

    #[Query]
    #[OA\Property(nullable: true)]
    private ?float $fromDistance = null;

    #[Query]
    #[OA\Property(nullable: true)]
    private ?float $toDistance = null;

    #[Query]
    #[OA\Property(type: 'array', items: new OA\Items(enum: DistanceTypeEnum::class), nullable: true)]
    private ?array $distanceTypes = null;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'ids' => ['nullable', 'array'],
            'ids.*' => ['uuid'],
            'fromDistance' => ['nullable', 'numeric', 'min:0'],
            'toDistance' => ['nullable', 'numeric', 'min:0'],
            'distanceTypes' => ['nullable', 'array'],
            'distanceTypes.*' => [Rule::enum(DistanceTypeEnum::class)],
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
        ]);
    }

    /**
     * @return UuidInterface[]|null
     */
    public function getIds(): ?array
    {
        return $this->ids ? \array_map(static fn(string $id) => Uuid::fromString($id), $this->ids) : null;
    }

    public function getFromDistance(): ?float
    {
        return $this->fromDistance;
    }

    public function getToDistance(): ?float
    {
        return $this->toDistance;
    }

    /**
     * @return DomainDistanceTypeEnum[]|null
     */
    public function getDistanceTypes(): ?array
    {
        return $this->distanceTypes ? \array_map(
            static fn(string $type) => match (DistanceTypeEnum::from($type)) {
                DistanceTypeEnum::meters => DomainDistanceTypeEnum::meters,
                DistanceTypeEnum::kilometers => DomainDistanceTypeEnum::kilometers,
                DistanceTypeEnum::miles => DomainDistanceTypeEnum::miles,
            },
            $this->distanceTypes,
        ) : null;
    }
}
