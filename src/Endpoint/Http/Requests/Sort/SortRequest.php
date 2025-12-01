<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Sort;

use App\Endpoint\Http\Enums\Sort\SortDirectionEnum;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Illuminate\Validation\Rule;
use Spiral\Validation\Laravel\FilterDefinition;

final class SortRequest extends Filter implements HasFilterDefinition
{
    #[Query]
    private ?string $field = null;

    #[Query]
    private ?string $direction = null;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'field' => ['string'],
            'direction' => ['string', Rule::enum(SortDirectionEnum::class)],
        ]);
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function getDirection(): ?SortDirectionEnum
    {
        return $this->direction ? SortDirectionEnum::from($this->direction) : null;
    }
}
