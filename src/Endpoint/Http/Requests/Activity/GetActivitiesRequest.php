<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Activity;

use App\Endpoint\Http\Requests\Pagination\PaginationRequestTrait;
use App\Endpoint\Http\Requests\Sort\SortRequestTrait;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validation\Laravel\FilterDefinition;

final class GetActivitiesRequest extends Filter implements HasFilterDefinition
{
    use PaginationRequestTrait;
    use SortRequestTrait;

    #[Query]
    private ?string $fromDate = null;

    #[Query]
    private ?string $toDate = null;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'fromDate' => ['date'],
            'toDate' => ['date'],
            'page' => ['integer'],
            'limit' => ['integer'],
        ]);
    }

    public function getFromDate(): ?\DateTimeImmutable
    {
        return $this->fromDate ? new \DateTimeImmutable($this->fromDate) : null;
    }

    public function getToDate(): ?\DateTimeImmutable
    {
        return $this->toDate ? new \DateTimeImmutable($this->toDate) : null;
    }
}
