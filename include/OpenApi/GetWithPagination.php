<?php

declare(strict_types=1);

namespace RR\OpenApi;

use OpenApi\Attributes\ExternalDocumentation;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\QueryParameter;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Schema;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class GetWithPagination extends Get
{
    public function __construct(
        ?string $path = null,
        ?string $operationId = null,
        ?string $description = null,
        ?string $summary = null,
        ?array $security = null,
        ?array $servers = null,
        ?RequestBody $requestBody = null,
        ?array $tags = null,
        ?array $responses = null,
        ?array $callbacks = null,
        ?ExternalDocumentation $externalDocs = null,
        ?bool $deprecated = null,
        ?array $x = null,
        ?array $attachables = null,
    ) {
        parent::__construct(
            path: $path,
            operationId: $operationId,
            description: $description,
            summary: $summary,
            security: $security,
            servers: $servers,
            requestBody: $requestBody,
            tags: $tags,
            parameters: [
                new QueryParameter(name: 'page', schema: new Schema(type: 'integer')),
                new QueryParameter(name: 'pageSize', schema: new Schema(type: 'integer')),
            ],
            responses: $responses,
            callbacks: $callbacks,
            externalDocs: $externalDocs,
            deprecated: $deprecated,
            x: $x,
            attachables: $attachables,
        );
    }
}
