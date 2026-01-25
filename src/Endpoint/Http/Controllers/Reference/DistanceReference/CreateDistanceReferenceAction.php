<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Reference\DistanceReference;

use App\Application\UseCases\Command\Reference\DistanceReference\CreateDistanceReference\CreateDistanceReferenceCommand;
use App\Application\UseCases\Command\Reference\DistanceReference\CreateDistanceReference\CreateDistanceReferenceCommandHandler;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Requests\Reference\DistanceReference\CreateDistanceReferenceRequest;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/references/distances', tags: ['Distance References'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: CreateDistanceReferenceRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class CreateDistanceReferenceAction
{
    #[Route(route: '/references/distances', name: 'references.distances.create', methods: ['POST'], group: 'auth_api')]
    public function __invoke(
        UserContext $userContext,
        CreateDistanceReferenceRequest $request,
        CreateDistanceReferenceCommandHandler $handler,
    ): void {
        $handler->handle(new CreateDistanceReferenceCommand(
            userId: $userContext->getId(),
            distance: $request->getDistance(),
        ));
    }
}
