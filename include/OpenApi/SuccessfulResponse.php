<?php

declare(strict_types=1);

namespace RR\OpenApi;

use OpenApi\Attributes\Attachable;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\XmlContent;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class SuccessfulResponse extends Response
{
    public function __construct(MediaType|JsonContent|XmlContent|Attachable|array|null $content = null)
    {
        parent::__construct(response: '200', description: 'Successful operation', content: $content);
    }
}
