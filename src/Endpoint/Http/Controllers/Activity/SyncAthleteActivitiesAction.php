<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Activity;

use App\Application\UseCases\Command\Activity\SyncActivities\SyncActivitiesCommand;
use App\Application\UseCases\Command\Activity\SyncActivities\SyncActivitiesCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/api/activities/sync', tags: ['Activities'])]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class SyncAthleteActivitiesAction
{
    #[Route(route: '/api/activities/sync', name: 'athlete.activities.sync', methods: ['POST'], group: 'auth_api')]
    public function __invoke(
        UserContext $userContext,
        SyncActivitiesCommandHandler $handler,
    ): void {
        $handler->handle(new SyncActivitiesCommand(athleteId: $userContext->getId()));
    }
}
