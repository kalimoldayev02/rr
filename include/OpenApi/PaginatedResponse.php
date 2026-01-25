<?php

declare(strict_types=1);

namespace RR\OpenApi;

use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PaginatedResponse extends SuccessfulResponse
{
    public function __construct(string $itemsRef, string $itemsProperty = 'items')
    {
        parent::__construct(content: new JsonContent(properties: [
            new Property(property: 'pagination', properties: [
                new Property(property: 'total', type: 'integer'),
                new Property(property: 'perPage', type: 'integer'),
                new Property(property: 'current', type: 'integer'),
            ], type: 'object'),
            new Property(property: $itemsProperty, type: 'array', items: new Items(ref: $itemsRef)),
        ]));
    }
}
