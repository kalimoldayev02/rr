<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Athlete;

use App\Application\UseCases\Query\Athlete\GetRegisterAthleteUrl\GetRegisterAthleteUrlQueryHandler;
use App\Endpoint\Http\Responses\Athlete\GetRegisterAthleteUrlResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/api/athlete/auth/url', tags: ['Athlete'])]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: GetRegisterAthleteUrlResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetRegisterAthleteUrlAction
{
    #[Route(route: '/api/athlete/auth/url', name: 'athlete.auth.url', methods: ['GET'], group: 'api')]
    public function __invoke(
        GetRegisterAthleteUrlQueryHandler $handler,
    ): GetRegisterAthleteUrlResponse {
        return new GetRegisterAthleteUrlResponse(
            url: $handler->handle(),
        );
    }
}
