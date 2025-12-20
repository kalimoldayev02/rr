<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\UseCases\Query\Event\GetEventById\GetEventByIdQuery;
use App\Application\UseCases\Query\Event\GetEventById\GetEventByIdQueryHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Mappers\Event\EventDTOToDetailEventResponseMapper;
use App\Endpoint\Http\Responses\Event\DetailEventResponse;
use Ramsey\Uuid\Uuid;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/api/events/{eventId}', tags: ['Events'])]
#[OA\PathParameter(name: 'eventId', schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: DetailEventResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetEventByIdAction
{
    #[Route(route: '/api/events/<eventId:uuid>', name: 'events.get', methods: ['GET'], group: 'auth_api')]
    public function __invoke(
        string $eventId,
        UserContext $userContext,
        GetEventByIdQueryHandler $handler,
        EventDTOToDetailEventResponseMapper $responseMapper,
    ): DetailEventResponse {
        $event = $handler->handle(new GetEventByIdQuery(
            userId: $userContext->getId(),
            id: Uuid::fromString($eventId),
        ));

        return $responseMapper->map($event);
    }
}
