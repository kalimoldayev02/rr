<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Activity;

use App\Application\UseCases\Query\Activity\GetActivityById\GetActivityByIdQuery;
use App\Application\UseCases\Query\Activity\GetActivityById\GetActivityByIdQueryHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Mappers\Activity\ActivityDTOToActivityDetailResponseMapper;
use App\Endpoint\Http\Responses\Activity\ActivityDetailResponse;
use Ramsey\Uuid\Uuid;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/api/activities/{activityId}', tags: ['Activities'])]
#[OA\PathParameter(name: 'activityId', schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: ActivityDetailResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetActivityByIdAction
{
    #[Route(route: '/api/activities/<activityId:uuid>', name: 'athlete.activities.get', methods: ['GET'], group: 'auth_api')]
    public function __invoke(
        UserContext $userContext,
        string $activityId,
        GetActivityByIdQueryHandler $handler,
        ActivityDTOToActivityDetailResponseMapper $responseMapper,
    ): ActivityDetailResponse {
        $activity = $handler->handle(new GetActivityByIdQuery(id: Uuid::fromString($activityId)));

        return $responseMapper->map($activity);
    }
}
