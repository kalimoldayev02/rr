<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\UseCases\Command\Event\CreateEvent\CreateEventCommand;
use App\Application\UseCases\Command\Event\CreateEvent\CreateEventCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Requests\Event\CreateEventRequest;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/api/events', tags: ['Events'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: CreateEventRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class CreateEventAction
{
    #[Route(route: '/api/events', name: 'events.create', methods: ['POST'], group: 'auth_api')]
    public function __invoke(
        UserContext $userContext,
        CreateEventRequest $request,
        CreateEventCommandHandler $handler,
    ): void {
        $handler->handle(new CreateEventCommand(
            userId: $userContext->getId(),
            clubId: $request->getClubId(),
            title: $request->getTitle(),
            date: $request->getDate(),
        ));
    }
}
