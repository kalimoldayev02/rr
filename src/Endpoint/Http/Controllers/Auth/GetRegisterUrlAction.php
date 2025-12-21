<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Auth;

use App\Endpoint\Http\Responses\Auth\GetRegisterUrlResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;
use App\Application\UseCases\Query\Auth\GetRegisterUrl\GetRegisterUrlQueryHandler;

#[OA\Get(path: '/api/auth/url', tags: ['Auth'])]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: GetRegisterUrlResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetRegisterUrlAction
{
    #[Route(route: '/api/auth/url', name: 'auth.url', methods: ['GET'], group: 'api')]
    public function __invoke(
        GetRegisterUrlQueryHandler $handler,
    ): GetRegisterUrlResponse {
        return new GetRegisterUrlResponse(
            url: $handler->handle(),
        );
    }
}
