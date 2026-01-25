<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\UseCases\Command\Event\AddEventResult\AddEventResultCommand;
use App\Application\UseCases\Command\Event\AddEventResult\AddEventResultCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Requests\Event\AddEventResultRequest;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/events/{eventId}/results', tags: ['Event Results'])]
#[OA\Parameter(name: 'eventId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[OA\RequestBody(content: new OA\JsonContent(ref: AddEventResultRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class AddEventResultAction
{
    #[Route(route: '/events/<eventId:uuid>/results', name: 'events.results.add', methods: ['POST'], group: 'auth_api')]
    public function __invoke(
        string $eventId,
        UserContext $userContext,
        AddEventResultRequest $request,
        AddEventResultCommandHandler $handler,
    ): void {
        $handler->handle(new AddEventResultCommand(
            eventId: Uuid::fromString($eventId),
            athleteId: $userContext->getId(),
            activityId: $request->getActivityId(),
            distanceId: $request->getDistanceId(),
            duration: $request->getDuration(),
        ));
    }
}
