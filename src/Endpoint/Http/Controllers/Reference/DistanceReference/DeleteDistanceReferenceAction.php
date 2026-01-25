<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Reference\DistanceReference;

use App\Application\UseCases\Command\Reference\DistanceReference\DeleteDistanceReference\DeleteDistanceReferenceCommand;
use App\Application\UseCases\Command\Reference\DistanceReference\DeleteDistanceReference\DeleteDistanceReferenceCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Delete(path: '/references/distances/{distanceReferenceId}', tags: ['Distance References'])]
#[OA\Parameter(name: 'distanceReferenceId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
final readonly class DeleteDistanceReferenceAction
{
    #[Route(route: '/references/distances/<distanceReferenceId:uuid>', name: 'references.distances.delete', methods: ['DELETE'], group: 'auth_api')]
    public function __invoke(
        string $distanceReferenceId,
        UserContext $userContext,
        DeleteDistanceReferenceCommandHandler $handler,
    ): void {
        $handler->handle(new DeleteDistanceReferenceCommand(
            userId: $userContext->getId(),
            distanceReferenceId: Uuid::fromString($distanceReferenceId),
        ));
    }
}
