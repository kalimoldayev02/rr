<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers;

use OpenApi\Annotations\OpenApi;
use OpenApi\Attributes as OA;
use OpenApi\Generator;
use Spiral\Router\Annotation\Route;

#[OA\OpenApi(
    info: new OA\Info(version: '1', title: 'RR API documentation'),
    servers: [new OA\Server(url: 'http://localhost', description: 'RR API server')],
    security: [['bearerAuth' => []]],
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    description: 'JWT Token',
    name: 'Authorization',
    in: 'header',
    bearerFormat: 'JWT',
    scheme: 'bearer',
)]
final readonly class SwaggerAction
{
    #[Route(route: '/docs', name: 'docs.get', methods: ['GET'], group: 'docs')]
    public function __invoke(): OpenApi
    {
        return new Generator()->generate([__DIR__ . '/../']);
    }
}
