<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Reference\DistanceReference;

use App\Domain\Enums\Activity\DistanceTypeEnum as DomainDistanceTypeEnum;
use App\Domain\ValueObjects\DistanceVO;
use App\Endpoint\Http\Enums\Activity\DistanceTypeEnum;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Validation\Laravel\FilterDefinition;

trait StoreDistanceReferenceRequestTrait
{
    #[Post]
    #[OA\Property]
    private float $distance;

    #[Post]
    #[OA\Property(enum: DistanceTypeEnum::class)]
    private string $distanceType;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'distance' => ['required', 'numeric', 'min:0'],
            'distanceType' => ['required', 'string', Rule::enum(DistanceTypeEnum::class)],
        ]);
    }

    public function getDistance(): DistanceVO
    {
        return new DistanceVO(
            value: $this->distance,
            type: match (DistanceTypeEnum::from($this->distanceType)) {
                DistanceTypeEnum::meters => DomainDistanceTypeEnum::meters,
                DistanceTypeEnum::kilometers => DomainDistanceTypeEnum::kilometers,
                DistanceTypeEnum::miles => DomainDistanceTypeEnum::miles,
            },
        );
    }
}
