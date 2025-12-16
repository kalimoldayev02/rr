<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Event;

use OpenApi\Attributes as OA;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\HasFilterDefinition;

#[OA\Schema]
final class CreateEventRequest extends Filter implements HasFilterDefinition
{
    use StoreEventRequestTrait;
}
