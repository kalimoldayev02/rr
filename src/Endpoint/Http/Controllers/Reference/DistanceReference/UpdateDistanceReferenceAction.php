<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Reference\DistanceReference;

use App\Application\UseCases\Command\Reference\DistanceReference\UpdateDistanceReference\UpdateDistanceReferenceCommand;
use App\Application\UseCases\Command\Reference\DistanceReference\UpdateDistanceReference\UpdateDistanceReferenceCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Requests\Reference\DistanceReference\UpdateDistanceReferenceRequest;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Put(path: '/references/distances/{distanceReferenceId}', tags: ['Distance References'])]
#[OA\Parameter(name: 'distanceReferenceId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))]
#[OA\RequestBody(content: new OA\JsonContent(ref: UpdateDistanceReferenceRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class UpdateDistanceReferenceAction
{
    #[Route(route: '/references/distances/<distanceReferenceId:uuid>', name: 'references.distances.update', methods: ['PUT'], group: 'auth_api')]
    public function __invoke(
        string $distanceReferenceId,
        UserContext $userContext,
        UpdateDistanceReferenceRequest $request,
        UpdateDistanceReferenceCommandHandler $handler,
    ): void {
        $handler->handle(new UpdateDistanceReferenceCommand(
            userId: $userContext->getId(),
            distanceReferenceId: Uuid::fromString($distanceReferenceId),
            distance: $request->getDistance(),
        ));
    }
}
