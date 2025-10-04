<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Athlete;

use App\Application\UseCases\Query\Athlete\GetAuthURL\GetAuthURLQueryHandler;
use App\Endpoint\Http\Responses\Athlete\GetAuthURLResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/api/athlete/auth/url', tags: ['auth'])]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: GetAuthURLResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetAuthURLAction
{
    #[Route(route: '/api/athlete/auth/url', name: 'athlete.auth.url', methods: ['GET'], group: 'api')]
    public function __invoke(
        GetAuthURLQueryHandler $handler,
    ): GetAuthURLResponse {
        return new GetAuthURLResponse(
            url: $handler->handle(),
        );
    }
}
