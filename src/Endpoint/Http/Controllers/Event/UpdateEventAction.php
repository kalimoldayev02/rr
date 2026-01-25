<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\UseCases\Command\Event\UpdateEvent\UpdateEventCommand;
use App\Application\UseCases\Command\Event\UpdateEvent\UpdateEventCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Requests\Event\UpdateEventRequest;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Put(path: '/events/{eventId}', tags: ['Events'])]
#[OA\Parameter(name: 'eventId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[OA\RequestBody(content: new OA\JsonContent(ref: UpdateEventRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class UpdateEventAction
{
    #[Route(route: '/events/<eventId:uuid>', name: 'events.update', methods: ['PUT'], group: 'auth_api')]
    public function __invoke(
        string $eventId,
        UserContext $userContext,
        UpdateEventRequest $request,
        UpdateEventCommandHandler $handler,
    ): void {
        $handler->handle(new UpdateEventCommand(
            userId: $userContext->getId(),
            eventId: Uuid::fromString($eventId),
            clubId: $request->getClubId(),
            title: $request->getTitle(),
            date: $request->getDate(),
        ));
    }
}
