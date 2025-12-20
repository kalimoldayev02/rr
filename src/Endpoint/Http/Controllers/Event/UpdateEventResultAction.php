<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\UseCases\Command\Event\UpdateEventResult\UpdateEventResultCommand;
use App\Application\UseCases\Command\Event\UpdateEventResult\UpdateEventResultCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Requests\Event\UpdateEventResultRequest;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Put(path: '/api/events/{eventId}/results/{eventResultId}', tags: ['Event Results'])]
#[OA\Parameter(name: 'eventId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[OA\Parameter(name: 'eventResultId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[OA\RequestBody(content: new OA\JsonContent(ref: UpdateEventResultRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class UpdateEventResultAction
{
    #[Route(route: '/api/events/<eventId:uuid>/results/<eventResultId:uuid>', name: 'events.results.update', methods: ['PUT'], group: 'auth_api')]
    public function __invoke(
        string $eventId,
        string $eventResultId,
        UserContext $userContext,
        UpdateEventResultRequest $request,
        UpdateEventResultCommandHandler $handler,
    ): void {
        $handler->handle(new UpdateEventResultCommand(
            eventId: Uuid::fromString($eventId),
            eventResultId: Uuid::fromString($eventResultId),
            athleteId: $userContext->getId(),
            activityId: $request->getActivityId(),
            distanceId: $request->getDistanceId(),
            duration: $request->getDuration(),
        ));
    }
}
