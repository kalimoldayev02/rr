<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\UseCases\Command\Event\DeleteEvent\DeleteEventCommand;
use App\Application\UseCases\Command\Event\DeleteEvent\DeleteEventCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Delete(path: '/api/events/{eventId}', tags: ['Events'])]
#[OA\Parameter(name: 'eventId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
final readonly class DeleteEventAction
{
    #[Route(route: '/api/events/<eventId:uuid>', name: 'events.delete', methods: ['DELETE'], group: 'auth_api')]
    public function __invoke(
        string $eventId,
        UserContext $userContext,
        DeleteEventCommandHandler $handler,
    ): void {
        $handler->handle(new DeleteEventCommand(
            userId: $userContext->getId(),
            eventId: Uuid::fromString($eventId),
        ));
    }
}
