<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\UseCases\Command\Event\RemoveEventResult\RemoveEventResultCommand;
use App\Application\UseCases\Command\Event\RemoveEventResult\RemoveEventResultCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Delete(path: '/api/events/{eventId}/results/{eventResultId}', tags: ['Event Results'])]
#[OA\Parameter(name: 'eventId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[OA\Parameter(name: 'eventResultId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
final readonly class DeleteEventResultAction
{
    #[Route(route: '/api/events/<eventId:uuid>/results/<eventResultId:uuid>', name: 'events.results.delete', methods: ['DELETE'], group: 'auth_api')]
    public function __invoke(
        string $eventId,
        string $eventResultId,
        UserContext $userContext,
        RemoveEventResultCommandHandler $handler,
    ): void {
        $handler->handle(new RemoveEventResultCommand(
            eventId: Uuid::fromString($eventId),
            eventResultId: Uuid::fromString($eventResultId),
            athleteId: $userContext->getId(),
        ));
    }
}
